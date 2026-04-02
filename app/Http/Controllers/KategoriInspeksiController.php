<?php

namespace App\Http\Controllers;

use App\Models\KategoriInspeksi;
use Illuminate\Http\Request;

class KategoriInspeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriInspeksi::orderBy('id')->get();
        return view('master.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        // Auto generate ID (KT001, KT002, etc)
        $lastId = KategoriInspeksi::orderBy('id', 'desc')->pluck('id')->first();
        if ($lastId && preg_match('/KT(\d+)/', $lastId, $matches)) {
            $number = (int)$matches[1] + 1;
        } else {
            $number = 1;
        }
        $newId = 'KT' . str_pad($number, 3, '0', STR_PAD_LEFT);

        KategoriInspeksi::create([
            'id' => $newId,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan dengan ID ' . $newId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = KategoriInspeksi::findOrFail($id);
        return view('master.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kategori = KategoriInspeksi::findOrFail($id);
        $kategori->update($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriInspeksi::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
