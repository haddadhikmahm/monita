<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\KategoriInspeksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
