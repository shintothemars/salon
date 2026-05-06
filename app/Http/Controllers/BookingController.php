<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Employee;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Form reservasi: pilih service -> isi data
     */
    public function create($id)
    {
        $service   = Service::findOrFail($id);
        $employees = Employee::all();
        return view('booking', compact('service', 'employees'));
    }

    /**
     * Simpan reservasi -> cek double booking -> tampil konfirmasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'  => 'required|exists:services,id',
            'employee_id' => 'required|exists:employees,id',
            'name'        => 'required|string|max:100',
            'phone'       => 'required|string|max:20',
            // FIX: after:yesterday → hari ini & besok bisa booking
            'date'        => 'required|date|after:yesterday',
            'time'        => 'required|string',
        ]);

        // ============================================================
        // Validasi: Jam yang dipilih tidak boleh sudah terlewat
        // (Berlaku untuk booking hari ini, dengan buffer 15 menit)
        // ============================================================
        $bookingDate = \Carbon\Carbon::parse($request->date)->toDateString();
        $todayDate   = now()->toDateString();

        if ($bookingDate === $todayDate) {
            $bookingDateTime = \Carbon\Carbon::parse($request->date . ' ' . $request->time);
            $cutoff          = now()->addMinutes(15); // buffer 15 menit

            if ($bookingDateTime->lte($cutoff)) {
                return back()->withInput()->withErrors([
                    'time' => 'Waktu ' . $request->time . ' WIB sudah terlewat. Silakan pilih waktu yang masih tersedia.'
                ]);
            }
        }

        // ============================================================
        // Validasi Double Booking (tanggal + jam + stylist)
        // ============================================================
        $conflict = Booking::where('employee_id', $request->employee_id)
            ->whereDate('date', $request->date)
            ->where('time', $request->time)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'time' => 'Stylist ini sudah memiliki booking pada tanggal dan jam yang sama. Silakan pilih waktu atau stylist yang berbeda.'
            ]);
        }

        $service = Service::findOrFail($request->service_id);

        $booking = Booking::create([
            'service_id'   => $request->service_id,
            'employee_id'  => $request->employee_id,
            'user_id'      => Auth::id() ?? null,
            'name'         => $request->name,
            'phone'        => $request->phone,
            'date'         => \Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'time'         => $request->time,
            'total_price'  => $service->price,
            'booking_code' => 'GLW-' . strtoupper(uniqid()),
            'status'       => 'pending',
        ]);

        return redirect()->route('booking.confirmation', $booking->id);
    }

    /**
     * Halaman konfirmasi pemesanan
     */
    public function confirmation($id)
    {
        $booking = Booking::with(['service', 'employee'])->findOrFail($id);
        return view('confirmation', compact('booking'));
    }

    /**
     * Konfirmasi & selesai -> halaman success / tiket
     */
    public function confirm(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);
        return redirect()->route('booking.success', $booking->id);
    }

    /**
     * Halaman berhasil reservasi (tiket)
     */
    public function success($id)
    {
        $booking = Booking::with(['service', 'employee'])->findOrFail($id);
        return view('success', compact('booking'));
    }

    /**
     * Dashboard karyawan
     */
    public function index()
    {
        $user = Auth::user();

        $bookings = Booking::with(['service', 'user'])
            ->where('employee_id', $user->id)
            ->whereDate('date', now())
            ->get();

        return view('karyawan.dashboard', compact('bookings'));
    }

    // ================================================================
    // ADMIN: Halaman Kelola Semua Reservasi
    // ================================================================

    /**
     * Admin: tampil semua reservasi dengan DataTables
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['service', 'employee'])->latest()->get();
        $stats = [
            'total'     => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'done'      => Booking::where('status', 'done')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        return view('admin.bookings', compact('bookings', 'stats'));
    }

    /**
     * Admin: update status booking
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,done,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui menjadi ' . ucfirst($request->status),
            'status'  => $booking->status,
        ]);
    }

    // ================================================================
    // FULLCALENDAR: API Events (AJAX)
    // ================================================================

    /**
     * API endpoint untuk FullCalendar events
     */
    public function calendarEvents(Request $request)
    {
        $query = Booking::with(['service', 'employee']);

        // Filter by date range (dari FullCalendar)
        if ($request->filled('start')) {
            $query->whereDate('date', '>=', \Carbon\Carbon::parse($request->start)->toDateString());
        }
        if ($request->filled('end')) {
            $query->whereDate('date', '<=', \Carbon\Carbon::parse($request->end)->toDateString());
        }

        $bookings = $query->whereNotIn('status', ['cancelled'])->get();

        // Warna berdasarkan status:
        // pending  → kuning
        // confirmed → biru
        // done     → hijau
        $colorMap = [
            'pending'   => ['bg' => '#d4a017', 'border' => '#b8860b'],
            'confirmed' => ['bg' => '#3b82f6', 'border' => '#2563eb'],
            'done'      => ['bg' => '#22c55e', 'border' => '#16a34a'],
            'cancelled' => ['bg' => '#6b7280', 'border' => '#4b5563'],
        ];

        $events = $bookings->map(function ($booking) use ($colorMap) {
            $colors = $colorMap[$booking->status] ?? $colorMap['pending'];

            return [
                'id'             => $booking->id,
                'title'          => $booking->name . ' — ' . ($booking->service->name ?? '-'),
                'start'          => $booking->date . 'T' . $booking->time,
                'backgroundColor'=> $colors['bg'],
                'borderColor'    => $colors['border'],
                'textColor'      => '#ffffff',
                'extendedProps'  => [
                    'booking_code'=> $booking->booking_code,
                    'service'     => $booking->service->name ?? '-',
                    'employee'    => $booking->employee->name ?? '-',
                    'phone'       => $booking->phone,
                    'status'      => $booking->status,
                    'total_price' => number_format($booking->total_price, 0, ',', '.'),
                    'time'        => $booking->time,
                    'date'        => \Carbon\Carbon::parse($booking->date)->isoFormat('D MMMM YYYY'),
                ],
            ];
        });

        return response()->json($events);
    }

    // ================================================================
    // INVOICE PDF (DomPDF)
    // ================================================================

    /**
     * Halaman invoice (preview)
     */
    public function invoice($id)
    {
        $booking = Booking::with(['service', 'employee'])->findOrFail($id);
        return view('booking.invoice', compact('booking'));
    }

    /**
     * Download invoice sebagai PDF menggunakan DomPDF
     */
    public function downloadInvoice($id)
    {
        $booking = Booking::with(['service', 'employee'])->findOrFail($id);

        $pdf = Pdf::loadView('booking.invoice-pdf', compact('booking'))
            ->setPaper('a5', 'portrait');

        return $pdf->download('Invoice-' . $booking->booking_code . '.pdf');
    }
}