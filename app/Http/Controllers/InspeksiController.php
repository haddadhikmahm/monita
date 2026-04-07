<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\InspeksiDetail;
use App\Models\KategoriInspeksi;
use App\Models\LokasiInspeksi;
use App\Models\MasterData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InspeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inspeksi::with(['lokasi', 'petugas1']);

        // Filtering Logic
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('tanggal', Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year);
                    break;
                case 'this_year':
                    $query->whereYear('tanggal', Carbon::now()->year);
                    break;
            }
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('tanggal', [$request->date_from, $request->date_to]);
        }

        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('details.masterData', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('data_id')) {
            $query->whereHas('details', function($q) use ($request) {
                $q->where('data_id', $request->data_id);
            });
        }

        $inspeksis = $query->orderBy('tanggal', 'desc')->get();
        $lokasis = LokasiInspeksi::all();
        $kategories = KategoriInspeksi::all();
        $all_alat = MasterData::all();

        return view('inspeksi.index', compact('inspeksis', 'lokasis', 'kategories', 'all_alat'));
    }

    /**
     * Show the form for creating a new resource or show category list.
     */
    public function create()
    {
        $activeId = session('active_inspeksi_id');
        
        if ($activeId) {
            $inspeksi = Inspeksi::with('lokasi')->find($activeId);
            
            // If session ID is invalid, clear it
            if (!$inspeksi) {
                session()->forget('active_inspeksi_id');
                return redirect()->route('inspeksi.create');
            }

            $kategories = KategoriInspeksi::all();
            foreach ($kategories as $kat) {
                $kat->is_complete = $this->isCategoryComplete($activeId, $kat->id);
            }

            return view('inspeksi.category_list', compact('inspeksi', 'kategories'));
        }

        $lokasis = LokasiInspeksi::all();
        $petugas = User::where('role', 'petugas')->get();
        return view('inspeksi.create', compact('lokasis', 'petugas'));
    }

    /**
     * Start a new inspection session.
     */
    public function start(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'lokasi_id' => 'required',
            'petugas1_id' => 'required',
        ]);

        $inspeksiId = 'IDI' . rand(11111, 99999);
        
        Inspeksi::create([
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

        session(['active_inspeksi_id' => $inspeksiId]);

        return redirect()->route('inspeksi.create');
    }

    /**
     * Show equipment form for a specific category.
     */
    public function categoryForm($kategori_id)
    {
        $activeId = session('active_inspeksi_id');
        if (!$activeId) return redirect()->route('inspeksi.create');

        $kategori = KategoriInspeksi::findOrFail($kategori_id);
        $alats = MasterData::where('kategori_id', $kategori_id)->get();
        
        $existingDetails = InspeksiDetail::where('inspeksi_id', $activeId)
            ->whereIn('data_id', $alats->pluck('id'))
            ->get()
            ->keyBy('data_id');

        return view('inspeksi.category_form', compact('kategori', 'alats', 'existingDetails'));
    }

    /**
     * Save category equipment data.
     */
    public function saveCategory(Request $request, $kategori_id)
    {
        $activeId = session('active_inspeksi_id');
        if (!$activeId) return redirect()->route('inspeksi.create');

        DB::beginTransaction();
        try {
            $items = $request->input('items', []);
            foreach ($items as $dataId => $itemData) {
                if (isset($itemData['jml']) && $itemData['jml'] !== '') {
                    
                    $photoName = $itemData['existing_foto'] ?? null;
                    if ($request->hasFile("items.$dataId.foto")) {
                        $file = $request->file("items.$dataId.foto");
                        $photoName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('images/kondisi'), $photoName);
                    }

                    InspeksiDetail::updateOrCreate(
                        ['inspeksi_id' => $activeId, 'data_id' => $dataId],
                        [
                            'id' => $itemData['detail_id'] ?? 'DTI' . rand(11111, 99999),
                            'jumlah' => $itemData['jml'],
                            'kondisi_struktur' => $itemData['kondisi'] ?? 'Baik',
                            'keterangan' => $itemData['keterangan'] ?? null,
                            'foto' => $photoName,
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('inspeksi.create')->with('success', 'Kategori Berhasil Disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Finalize the inspection.
     */
    public function finish()
    {
        session()->forget('active_inspeksi_id');
        return redirect()->route('inspeksi.index')->with('success', 'Laporan Inspeksi Berhasil Diselesaikan.');
    }

    /**
     * Check if all tools in a category have been inspected.
     */
    private function isCategoryComplete($inspeksi_id, $kategori_id)
    {
        $totalAlat = MasterData::where('kategori_id', $kategori_id)->count();
        if ($totalAlat === 0) return true;

        $filledAlat = InspeksiDetail::where('inspeksi_id', $inspeksi_id)
            ->whereHas('masterData', function($q) use ($kategori_id) {
                $q->where('kategori_id', $kategori_id);
            })->count();

        return $filledAlat >= $totalAlat;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inspeksi = Inspeksi::with(['lokasi', 'petugas1', 'petugas2', 'petugas3', 'petugas4', 'details.masterData'])->findOrFail($id);
        return view('inspeksi.show', compact('inspeksi'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Inspeksi::findOrFail($id)->delete();
        return redirect()->route('inspeksi.index')->with('success', 'Data berhasil dihapus');
    }
}
