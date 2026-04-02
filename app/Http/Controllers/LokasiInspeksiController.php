<?php

namespace App\Http\Controllers;

use App\Models\LokasiInspeksi;
use Illuminate\Http\Request;

class LokasiInspeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = LokasiInspeksi::orderBy('id')->get();
        return view('master.lokasi.index', compact('lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        // Auto generate ID (L001, L002, etc)
        $lastId = LokasiInspeksi::orderBy('id', 'desc')->pluck('id')->first();
        if ($lastId && preg_match('/L(\d+)/', $lastId, $matches)) {
            $number = (int)$matches[1] + 1;
        } else {
            $number = 1;
        }
        $newId = 'L' . str_pad($number, 3, '0', STR_PAD_LEFT);

        LokasiInspeksi::create([
            'id' => $newId,
            'nama' => $request->nama,
        ]);

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil ditambahkan dengan ID ' . $newId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lokasi = LokasiInspeksi::findOrFail($id);
        return view('master.lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $lokasi = LokasiInspeksi::findOrFail($id);
        $lokasi->update($request->only('nama'));

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lokasi = LokasiInspeksi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
