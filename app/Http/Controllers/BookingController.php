<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Employee;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Simpan reservasi -> tampil halaman konfirmasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'  => 'required|exists:services,id',
            'employee_id' => 'required|exists:employees,id',
            'name'        => 'required|string|max:100',
            'phone'       => 'required|string|max:20',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        $booking = Booking::create([
            'service_id'   => $request->service_id,
            'employee_id'  => $request->employee_id,
            'user_id'      => Auth::id() ?? null,
            'name'         => $request->name,
            'phone'        => $request->phone,
            'date'         => $request->date,
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
}