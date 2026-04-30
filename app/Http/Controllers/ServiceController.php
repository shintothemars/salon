<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * List semua layanan (b. halaman list pilihan)
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    /**
     * Form tambah layanan (c. halaman tambah pilihan)
     */
    public function create()
    {
        return view('services.form');
    }

    /**
     * Simpan layanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:services,name',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:5|max:480',
            'description' => 'nullable|string|max:500',
        ]);

        Service::create($request->only(['name', 'price', 'duration', 'description']));

        return redirect()->route('services.index')
            ->with('success', 'Layanan "' . $request->name . '" berhasil ditambahkan!');
    }

    /**
     * Form edit layanan
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.form', compact('service'));
    }

    /**
     * Update layanan
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100|unique:services,name,' . $id,
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:5|max:480',
            'description' => 'nullable|string|max:500',
        ]);

        $service->update($request->only(['name', 'price', 'duration', 'description']));

        return redirect()->route('services.index')
            ->with('success', 'Layanan "' . $service->name . '" berhasil diperbarui!');
    }

    /**
     * Hapus layanan
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $name = $service->name;
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Layanan "' . $name . '" berhasil dihapus.');
    }
}
