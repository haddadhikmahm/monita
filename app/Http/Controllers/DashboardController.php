<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\InspeksiDetail;
use App\Models\LokasiInspeksi;
use App\Models\MasterData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Provide variables exactly as expected by the redesigned HUD
        $countData = MasterData::count();
        $countLokasi = LokasiInspeksi::count();
        $countUser = User::count();
        $countInspeksi = Inspeksi::count();

        // Chart Data: Equipment Condition Registry
        // Get counts for the specific categories used in the HUD doughnut chart
        $latestDetails = DB::table('inspeksi_datas as id1')
            ->select('id1.kondisi_struktur', DB::raw('count(*) as total'))
            ->whereIn('id1.id', function($query) {
                $query->select(DB::raw('max(id)'))
                    ->from('inspeksi_datas')
                    ->groupBy('data_id');
            })
            ->groupBy('id1.kondisi_struktur')
            ->get();

        $baik = 0;
        $ringan = 0;
        $berat = 0;

        foreach ($latestDetails as $detail) {
            if ($detail->kondisi_struktur == 'Baik') $baik = $detail->total;
            elseif ($detail->kondisi_struktur == 'Rusak Ringan') $ringan = $detail->total;
            elseif ($detail->kondisi_struktur == 'Rusak Berat') $berat = $detail->total;
        }

        return view('dashboard', compact(
            'countData', 
            'countLokasi', 
            'countUser', 
            'countInspeksi', 
            'baik', 
            'ringan', 
            'berat'
        ));
    }
}
