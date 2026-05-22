<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\KategoriInspeksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function downloadFilteredPdf(Request $request)
    {
        $inspeksis = Inspeksi::filter($request->all())
            ->with(['lokasi', 'petugas1', 'details.masterData'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Get filter labels for display in the PDF header
        $activeFilters = [];
        
        if ($request->filled('period')) {
            $periods = [
                'today' => 'Harian [Today]',
                'this_week' => 'Mingguan [This Week]',
                'this_month' => 'Bulanan [This Month]',
                'this_year' => 'Tahunan [This Year]'
            ];
            $activeFilters['Periode'] = $periods[$request->period] ?? $request->period;
        }

        if ($request->filled('date_from') || $request->filled('date_to')) {
            $dateRange = '';
            if ($request->filled('date_from')) {
                $dateRange .= \Carbon\Carbon::parse($request->date_from)->format('d/m/Y');
            } else {
                $dateRange .= 'Awal';
            }
            $dateRange .= ' s/d ';
            if ($request->filled('date_to')) {
                $dateRange .= \Carbon\Carbon::parse($request->date_to)->format('d/m/Y');
            } else {
                $dateRange .= 'Akhir';
            }
            $activeFilters['Rentang Tanggal'] = $dateRange;
        }

        if ($request->filled('lokasi_id')) {
            $lokasi = \App\Models\LokasiInspeksi::find($request->lokasi_id);
            $activeFilters['Lokasi'] = $lokasi ? $lokasi->nama : 'N/A';
        }

        if ($request->filled('kategori_id')) {
            $kategori = KategoriInspeksi::find($request->kategori_id);
            $activeFilters['Kategori Alat'] = $kategori ? $kategori->nama : 'N/A';
        }

        if ($request->filled('data_id')) {
            $alat = \App\Models\MasterData::find($request->data_id);
            $activeFilters['Alat Spesifik'] = $alat ? $alat->nama : 'N/A';
        }

        $pdf = Pdf::loadView('inspeksi.report_filtered', [
            'inspeksis' => $inspeksis,
            'activeFilters' => $activeFilters
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Rekap_Inspeksi_' . date('Ymd_His') . '.pdf');
    }

    public function downloadPdf($id)
    {
        $inspeksi = Inspeksi::with(['lokasi', 'petugas1', 'petugas2', 'petugas3', 'petugas4', 'details.masterData.kategori'])
            ->findOrFail($id);

        // Group details by category for the report
        $detailsByKategori = $inspeksi->details->groupBy(function($detail) {
            return $detail->masterData->kategori->nama;
        });

        $pdf = Pdf::loadView('inspeksi.report', [
            'inspeksi' => $inspeksi,
            'detailsByKategori' => $detailsByKategori
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Inspeksi_' . $inspeksi->id . '.pdf');
    }

    public function rekap()
    {
        // Simple summary of latest condition of all equipment
        $inspeksis = Inspeksi::with(['details.masterData.kategori', 'lokasi'])->orderBy('tanggal', 'desc')->get();
        return view('report.rekap', compact('inspeksis'));
    }
}
