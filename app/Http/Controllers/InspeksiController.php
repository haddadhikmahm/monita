<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\InspeksiDetail;
use App\Models\LokasiInspeksi;
use App\Models\MasterData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InspeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspeksis = Inspeksi::with(['lokasi', 'petugas1'])->orderBy('tanggal', 'desc')->get();
        return view('inspeksi.index', compact('inspeksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lokasis = LokasiInspeksi::all();
        $petugas = User::where('role', 'petugas')->get();
        
        // This is simplified. In the native app, different categories were shown on different pages or sections.
        // We will load equipment for the first location by default for simplicity in the create form.
        $kategories = MasterData::with('kategori')->get()->groupBy('kategori.nama');

        return view('inspeksi.create', compact('lokasis', 'petugas', 'kategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'lokasi_id' => 'required',
            'petugas1_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $inspeksiId = 'IDI' . rand(11111, 99999);
            
            $inspeksi = Inspeksi::create([
                'id' => $inspeksiId,
                'hari' => $request->hari,
                'tanggal' => $request->tanggal,
                'cuaca' => $request->cuaca,
                'w1' => $request->has('w1') ? 'Y' : 'N',
                'w2' => $request->has('w2') ? 'Y' : 'N',
                'lokasi_id' => $request->lokasi_id,
                'petugas1_id' => $request->petugas1_id,
                'petugas2_id' => $request->petugas2_id,
                'petugas3_id' => $request->petugas3_id,
                'petugas4_id' => $request->petugas4_id,
            ]);

            // Handling the dynamic fields for equipment
            $items = $request->input('items', []);
            foreach ($items as $dataId => $itemData) {
                if (isset($itemData['jml']) && $itemData['jml'] !== '') {
                    $detailId = 'DTI' . rand(11111, 99999);
                    
                    $photoName = null;
                    if ($request->hasFile("items.$dataId.foto")) {
                        $file = $request->file("items.$dataId.foto");
                        $photoName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('images/kondisi'), $photoName);
                    }

                    InspeksiDetail::create([
                        'id' => $detailId,
                        'inspeksi_id' => $inspeksiId,
                        'data_id' => $dataId,
                        'jumlah' => $itemData['jml'],
                        'kondisi_struktur' => $itemData['kondisi'] ?? null,
                        'foto' => $photoName,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('inspeksi.index')->with('success', 'Data Inspeksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inspeksi = Inspeksi::with(['lokasi', 'petugas1', 'petugas2', 'petugas3', 'petugas4', 'details.masterData'])->findOrFail($id);
        return view('inspeksi.show', compact('inspeksi'));
    }
}
