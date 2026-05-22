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
        $sedang = 0;
        $rusak = 0;

        foreach ($latestDetails as $detail) {
            if ($detail->kondisi_struktur == 'Baik') $baik = $detail->total;
            elseif ($detail->kondisi_struktur == 'Sedang') $sedang = $detail->total;
            elseif ($detail->kondisi_struktur == 'Rusak') $rusak = $detail->total;
        }

        // New Chart Data: Equipment per Category
        $categories = \App\Models\KategoriInspeksi::withCount('masterDatas')->get();
        
        // New Chart Data: Equipment per Location
        $locations = \App\Models\LokasiInspeksi::withCount('masterDatas')->take(10)->get();

        // New Chart Data: Monthly Inspection Trends (Last 6 months)
        if (DB::connection()->getDriverName() === 'sqlite') {
            $monthlyTrends = Inspeksi::select(
                    DB::raw("strftime('%m', created_at) as month"), 
                    DB::raw('count(*) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            
            $monthNames = [
                '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
            ];
            foreach ($monthlyTrends as $trend) {
                $trend->month = $monthNames[$trend->month] ?? $trend->month;
            }
        } else {
            $monthlyTrends = Inspeksi::select(
                    DB::raw('MONTHNAME(created_at) as month'), 
                    DB::raw('count(*) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month', DB::raw('MONTH(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'))
                ->get();
        }

        return view('dashboard', compact(
            'countData', 
            'countLokasi', 
            'countUser', 
            'countInspeksi', 
            'baik', 
            'sedang', 
            'rusak',
            'categories',
            'locations',
            'monthlyTrends'
        ));
    }
}
