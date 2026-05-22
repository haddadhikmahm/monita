<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Rekapitulasi Inspeksi</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #1e293b; line-height: 1.4; }
        .header { width: 100%; border-bottom: 2px solid #0f172a; padding-bottom: 12px; margin-bottom: 20px; }
        .logo { width: 130px; height: auto; }
        .title { text-align: center; }
        .title h4 { margin: 0; padding: 0; font-size: 10.5pt; font-weight: bold; text-transform: uppercase; color: #1e293b; letter-spacing: 0.5px; }
        .title p { margin: 2px 0 0 0; font-size: 8.5pt; font-weight: bold; color: #475569; text-transform: uppercase; }
        .title h3 { margin: 8px 0 0 0; padding: 0; font-size: 11.5pt; font-weight: 900; letter-spacing: 0.5px; color: #0f172a; }
        .period-text { font-size: 10pt; font-weight: 800; color: #0284c7; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 25px; }
        .data-table th, .data-table td { border: 1.5px solid #475569; padding: 8px 10px; text-align: left; }
        .data-table th { background-color: #f1f5f9; font-weight: 900; font-size: 8.5pt; text-transform: uppercase; color: #0f172a; }
        .data-table tr:nth-child(even) td { background-color: #f8fafc; }
        
        .signature-table { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-box { text-align: center; width: 50%; vertical-align: top; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 7.5pt; border-top: 1px solid #cbd5e1; padding-top: 4px; color: #64748b; }
    </style>
</head>
<body>
    @php
        // Calculate total counts for summary
        $allDetails = collect();
        foreach($inspeksis as $i) {
            foreach($i->details as $d) {
                $allDetails->push($d);
            }
        }

        // Group all details by master_data_id to get aggregates per equipment
        $groupedDetails = $allDetails->groupBy('data_id');

        $totalBaikQty = 0;
        $totalRusakQty = 0;

        $equipmentSummary = [];
        foreach($groupedDetails as $dataId => $detailsGroup) {
            $firstDetail = $detailsGroup->first();
            $alatName = $firstDetail->masterData?->nama ?? 'Unknown';

            // Sum the quantities based on condition
            $baikQty = $detailsGroup->where('kondisi_struktur', 'Baik')->sum('jumlah');
            $rusakQty = $detailsGroup->where('kondisi_struktur', 'Rusak')->sum('jumlah');
            
            $totalBaikQty += $baikQty;
            $totalRusakQty += $rusakQty;

            // Get unique, non-empty keterangan values only from broken items
            $keterangan = $detailsGroup->where('kondisi_struktur', 'Rusak')
                ->pluck('keterangan')
                ->filter()
                ->unique()
                ->implode(', ');

            $equipmentSummary[] = [
                'nama' => $alatName,
                'baik' => $baikQty,
                'rusak' => $rusakQty,
                'keterangan' => $keterangan,
            ];
        }
    @endphp

    <div class="header">
        <table width="100%">
            <tr>
                <td width="20%" style="vertical-align: middle;">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" class="logo">
                    @endif
                </td>
                <td width="80%" class="title" style="vertical-align: middle; text-align: center;">
                    <h4>PT. ANGKASA PURA INDONESIA</h4>
                    <p>KANTOR CABANG BANDARA UDARA SULTAN AJI MUHAMMAD SULAIMAN SEPINGGAN BALIKPAPAN</p>
                    <h3>DATA PERALATAN AIRPORT TECHNOLOGY SECTION</h3>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 20px; font-weight: bold; font-size: 10pt; text-align: left; text-transform: uppercase; color: #1e293b; padding-top: 8px;">
        PERIODE : {{ $periodeString }}
    </div>

    <!-- Table of Equipment Conditions (Precisely matching the mock drawing) -->
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" width="6%" style="text-align: center; vertical-align: middle;">NO</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left;">NAMA PERALATAN</th>
                <th colspan="2" style="text-align: center;">KONDISI</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: left;">KETERANGAN</th>
            </tr>
            <tr>
                <th width="12%" style="text-align: center;">BAIK</th>
                <th width="12%" style="text-align: center;">RUSAK</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipmentSummary as $idx => $eq)
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $idx + 1 }}</td>
                    <td style="font-weight: bold; color: #0f172a; text-align: left;">{{ $eq['nama'] }}</td>
                    <td style="text-align: center; color: #16a34a; font-weight: bold;">{{ $eq['baik'] }}</td>
                    <td style="text-align: center; color: #dc2626; font-weight: bold;">{{ $eq['rusak'] }}</td>
                    <td style="font-size: 8.5pt; color: #475569; text-align: left; vertical-align: middle;">{{ $eq['keterangan'] ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; font-style: italic; padding: 25px;">
                        Tidak ada data peralatan yang terinspeksi untuk periode ini.
                    </td>
                </tr>
            @endforelse
            @if(count($equipmentSummary) > 0)
                <tr style="background-color: #f1f5f9; font-weight: bold;">
                    <td colspan="2" style="text-align: left; font-weight: 900; text-transform: uppercase; padding-left: 10px;">JUMLAH PERALATAN</td>
                    <td style="text-align: center; color: #16a34a; font-weight: 900; font-size: 10pt;">{{ $totalBaikQty }}</td>
                    <td style="text-align: center; color: #dc2626; font-weight: 900; font-size: 10pt;">{{ $totalRusakQty }}</td>
                    <td style="background-color: #f1f5f9;"></td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Signature block -->
    <table class="signature-table">
        <tr>
            <td class="signature-box" style="text-align: left; font-size: 8.5pt; padding-left: 20px;">
                <strong>RINGKASAN LAPORAN:</strong><br>
                - Total Sesi Inspeksi Terkumpul: {{ $inspeksis->count() }}<br>
                - Dicetak Oleh: {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})<br>
                - Status Rekapitulasi: Terverifikasi / Sah
            </td>
            <td class="signature-box" style="font-size: 8.5pt;">
                Diketahui:<br>
                <strong>AIRPORT TECHNOLOGY MANAGER</strong><br><br>
                @if(file_exists(public_path('images/ttdhp.png')))
                    <img src="{{ public_path('images/ttdhp.png') }}" width="110"><br>
                @else
                    <br><br><br>
                @endif
                ( HERMAN PRAYITNO )
            </td>
        </tr>
    </table>

    <div class="footer">
        MONITA AIRPORT TECHNOLOGY SURVEILLANCE &bull; Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
