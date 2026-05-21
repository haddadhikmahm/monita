<?php

namespace App\Http\Controllers;

use App\Models\InspeksiDetail;
use App\Models\KategoriInspeksi;
use App\Models\LokasiInspeksi;
use App\Models\MasterData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of items needing maintenance (kondisi = Rusak).
     */
    public function index(Request $request)
    {
        $query = InspeksiDetail::with(['inspeksi.lokasi', 'masterData.kategori'])
            ->where('kondisi_struktur', 'Rusak');

        // Filtering Logic (consistent with Inspeksi)
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereHas('inspeksi', function($q) {
                        $q->whereDate('tanggal', Carbon::today());
                    });
                    break;
                case 'this_week':
                    $query->whereHas('inspeksi', function($q) {
                        $q->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    });
                    break;
                case 'this_month':
                    $query->whereHas('inspeksi', function($q) {
                        $q->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year);
                    });
                    break;
                case 'this_year':
                    $query->whereHas('inspeksi', function($q) {
                        $q->whereYear('tanggal', Carbon::now()->year);
                    });
                    break;
            }
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereHas('inspeksi', function($q) use ($request) {
                $q->whereBetween('tanggal', [$request->date_from, $request->date_to]);
            });
        }

        if ($request->filled('lokasi_id')) {
            $query->whereHas('inspeksi', function($q) use ($request) {
                $q->where('lokasi_id', $request->lokasi_id);
            });
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('masterData', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('data_id')) {
            $query->where('data_id', $request->data_id);
        }

        // Filter by Status Perbaikan
        if ($request->filled('status_perbaikan')) {
            if ($request->status_perbaikan == 'pending') {
                $query->where('is_repaired', false);
            } elseif ($request->status_perbaikan == 'repaired') {
                $query->where('is_repaired', true);
            }
        }

        $maintenanceItems = $query->orderBy('created_at', 'desc')->get();
        $lokasis = LokasiInspeksi::all();
        $kategories = KategoriInspeksi::all();
        $all_alat = MasterData::all();

        return view('maintenance.index', compact('maintenanceItems', 'lokasis', 'kategories', 'all_alat'));
    }

    /**
     * Store or update repair log for a maintenance item.
     */
    public function repair(Request $request, $id)
    {
        $request->validate([
            'kondisi_perbaikan' => 'required|in:Baik,Tidak Baik',
            'keterangan_perbaikan' => 'required|string',
            'tgl_perbaikan' => 'required|date',
            'foto_perbaikan' => 'nullable|image|max:2048',
        ]);

        $detail = InspeksiDetail::findOrFail($id);

        $photoName = $detail->foto_perbaikan;
        if ($request->hasFile('foto_perbaikan')) {
            $file = $request->file('foto_perbaikan');
            $photoName = 'repair_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/kondisi'), $photoName);
        }

        $detail->update([
            'is_repaired' => $request->kondisi_perbaikan == 'Baik',
            'tgl_perbaikan' => $request->tgl_perbaikan,
            'kondisi_perbaikan' => $request->kondisi_perbaikan,
            'keterangan_perbaikan' => $request->keterangan_perbaikan,
            'foto_perbaikan' => $photoName,
        ]);

        return redirect()->route('maintenance.index')->with('success', 'Data Perbaikan Berhasil Disimpan.');
    }
}
