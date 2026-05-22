<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Rekapitulasi Inspeksi</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #333; line-height: 1.3; }
        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
        .logo { width: 140px; height: auto; }
        .title { text-align: center; }
        .title h3 { margin: 0; padding: 0; font-size: 13pt; letter-spacing: 1px; }
        .title p { margin: 3px 0 0 0; font-size: 9pt; font-weight: bold; }
        
        .filter-section { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 12px; margin-bottom: 15px; border-radius: 4px; }
        .filter-title { font-weight: bold; font-size: 8.5pt; color: #1e293b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        .filter-grid { width: 100%; }
        .filter-grid td { font-size: 8pt; padding: 2px 4px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .data-table th, .data-table td { border: 1px solid #94a3b8; padding: 6px 8px; text-align: left; }
        .data-table th { background-color: #f1f5f9; font-weight: bold; font-size: 8.5pt; text-transform: uppercase; color: #1e293b; }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }
        
        .status-badge { display: inline-block; padding: 2px 5px; font-size: 7.5pt; font-weight: bold; border-radius: 3px; text-transform: uppercase; }
        .badge-ok { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-err { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-fix { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .text-mono { font-family: Courier, monospace; }
        
        .signature-table { width: 100%; margin-top: 20px; page-break-inside: avoid; }
        .signature-box { text-align: center; width: 50%; vertical-align: top; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 7.5pt; border-top: 1px solid #cbd5e1; padding-top: 4px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td width="25%"><img src="{{ public_path('images/logo.png') }}" class="logo"></td>
                <td width="75%" class="title">
                    <h3>LAPORAN REKAPITULASI INSPEKSI FASILITAS AIRPORT TECHNOLOGY</h3>
                    <p>DI BANDARA INTERNASIONAL SAMS SEPINGGAN BALIKPAPAN</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Active Filters Display -->
    <div class="filter-section">
        <div class="filter-title">Parameter Pencarian / Filter Aktif</div>
        @if(count($activeFilters) > 0)
            <table class="filter-grid">
                <tr>
                    @php $colCount = 0; @endphp
                    @foreach($activeFilters as $key => $val)
                        @if($colCount > 0 && $colCount % 3 == 0)
                            </tr><tr>
                        @endif
                        <td width="33%"><strong>{{ $key }}:</strong> {{ $val }}</td>
                        @php $colCount++; @endphp
                    @endforeach
                    @while($colCount % 3 != 0)
                        <td width="33%"></td>
                        @php $colCount++; @endphp
                    @endwhile
                </tr>
            </table>
        @else
            <div style="font-size: 8pt; color: #64748b; font-style: italic;">Semua Data (Tidak Ada Filter yang Diterapkan)</div>
        @endif
    </div>

    <!-- Log Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%" style="text-align: center;">No</th>
                <th width="12%">ID Referensi</th>
                <th width="12%">Tanggal</th>
                <th width="10%">Hari</th>
                <th width="18%">Node Lokasi</th>
                <th width="10%">Cuaca</th>
                <th width="16%">Operator Utama</th>
                <th width="18%">Surveillance Matriks Alat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inspeksis as $index => $i)
                @php
                    $details = $i->details;
                    $rusak = $details->where('kondisi_struktur', 'Rusak')->count();
                    $repaired = $details->where('kondisi_struktur', 'Rusak')->where('is_repaired', true)->count();
                    $pending = $rusak - $repaired;
                    $baik = $details->where('kondisi_struktur', 'Baik')->count();
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td class="text-mono">#{{ str_pad($i->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $i->tanggal->format('d/m/Y') }}</td>
                    <td style="text-transform: uppercase;">{{ $i->hari }}</td>
                    <td style="font-weight: bold; color: #0f172a;">{{ $i->lokasi->nama }}</td>
                    <td>
                        <span style="text-transform: uppercase; font-size: 8pt; font-weight: bold; color: #0284c7;">{{ $i->cuaca }}</span>
                    </td>
                    <td>{{ $i->petugas1->name }}</td>
                    <td>
                        <span class="status-badge badge-ok">{{ $baik }} OK</span>
                        @if($rusak > 0)
                            @if($pending > 0)
                                <span class="status-badge badge-err">{{ $pending }} ERR</span>
                            @endif
                            @if($repaired > 0)
                                <span class="status-badge badge-fix">{{ $repaired }} FIX</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #64748b; font-style: italic; padding: 20px;">
                        Tidak ada catatan log inspeksi yang cocok dengan filter saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature block -->
    <table class="signature-table">
        <tr>
            <td class="signature-box" style="text-align: left; font-size: 8.5pt;">
                <strong>RINGKASAN LAPORAN:</strong><br>
                - Total Sesi Inspeksi: {{ $inspeksis->count() }}<br>
                - Dicetak Oleh: {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})<br>
                - Status Sistem: Nominal / Terverifikasi
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
