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
            ->with([
                'lokasi',
                'petugas1',
                'details' => function($q) use ($request) {
                    if ($request->filled('kategori_id')) {
                        $q->whereHas('masterData', function($mq) use ($request) {
                            $mq->where('kategori_id', $request->kategori_id);
                        });
                    }
                    if ($request->filled('sub_kategori')) {
                        $q->whereHas('masterData', function($mq) use ($request) {
                            $mq->where('sub_kategori', $request->sub_kategori);
                        });
                    }
                    if ($request->filled('data_id')) {
                        $q->where('data_id', $request->data_id);
                    }
                    $q->with(['masterData.kategori']);
                }
            ])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Calculate explicit start and end dates for the period string
        $dateFrom = null;
        $dateTo = null;

        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $dateFrom = \Carbon\Carbon::today();
                    $dateTo = \Carbon\Carbon::today();
                    break;
                case 'this_week':
                    $dateFrom = \Carbon\Carbon::now()->startOfWeek();
                    $dateTo = \Carbon\Carbon::now()->endOfWeek();
                    break;
                case 'this_month':
                    $dateFrom = \Carbon\Carbon::now()->startOfMonth();
                    $dateTo = \Carbon\Carbon::now()->endOfMonth();
                    break;
                case 'this_year':
                    $dateFrom = \Carbon\Carbon::now()->startOfYear();
                    $dateTo = \Carbon\Carbon::now()->endOfYear();
                    break;
            }
        }

        if ($request->filled('date_from')) {
            $dateFrom = \Carbon\Carbon::parse($request->date_from);
        }
        if ($request->filled('date_to')) {
            $dateTo = \Carbon\Carbon::parse($request->date_to);
        }

        // If no dates are set, get min/max dates from filtered results
        if (!$dateFrom && $inspeksis->isNotEmpty()) {
            $dateFrom = $inspeksis->min('tanggal');
        }
        if (!$dateTo && $inspeksis->isNotEmpty()) {
            $dateTo = $inspeksis->max('tanggal');
        }

        // If still empty, default to current day
        if (!$dateFrom) $dateFrom = \Carbon\Carbon::today();
        if (!$dateTo) $dateTo = \Carbon\Carbon::today();

        $periodeString = $dateFrom->format('d/m/Y') . ' - ' . $dateTo->format('d/m/Y');

        $pdf = Pdf::loadView('inspeksi.report_filtered', [
            'inspeksis' => $inspeksis,
            'periodeString' => $periodeString
        ])->setPaper('a4', 'portrait'); // portrait matches regular table layout best! Let's check how the user wants it, portrait or landscape. The user's mock is a standard vertical layout, so portrait is great! Let's set to portrait.

        return $pdf->stream('Laporan_Rekap_Inspeksi_' . date('Ymd_His') . '.pdf');
    }

    public function downloadPdf($id)
    {
        $inspeksi = Inspeksi::with(['lokasi', 'petugas1', 'petugas2', 'petugas3', 'petugas4', 'details.masterData.kategori'])
            ->findOrFail($id);

        // Group details by category for the report
        $detailsByKategori = $inspeksi->details->groupBy(function($detail) {
            return $detail->masterData?->kategori?->nama ?? 'Lain-lain';
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
