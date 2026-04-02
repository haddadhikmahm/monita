<?php

namespace App\Http\Controllers;

use App\Models\KategoriInspeksi;
use App\Models\LokasiInspeksi;
use App\Models\MasterData;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = MasterData::with(['kategori', 'lokasi'])->orderBy('id')->get();
        return view('master.data.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategories = KategoriInspeksi::all();
        $lokasis = LokasiInspeksi::all();
        return view('master.data.create', compact('kategories', 'lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'lokasi_id' => 'required',
        ]);

        // Auto generate ID (KD + 8 random digits, or KD + increment if preferred)
        // Let's use KD + random 8 digits to match the legacy style
        do {
            $newId = 'KD' . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        } while (MasterData::find($newId));

        MasterData::create([
            'id' => $newId,
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->route('master-data.index')->with('success', 'Data peralatan berhasil ditambahkan dengan ID ' . $newId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MasterData::findOrFail($id);
        $kategories = KategoriInspeksi::all();
        $lokasis = LokasiInspeksi::all();
        return view('master.data.edit', compact('data', 'kategories', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'lokasi_id' => 'required',
        ]);

        $data = MasterData::findOrFail($id);
        $data->update($request->only('nama', 'kategori_id', 'lokasi_id'));

        return redirect()->route('master-data.index')->with('success', 'Data peralatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MasterData::findOrFail($id);
        $data->delete();

        return redirect()->route('master-data.index')->with('success', 'Data peralatan berhasil dihapus.');
    }
}
