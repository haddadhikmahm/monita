<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Inspeksi - {{ $inspeksi->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10pt; color: #333; line-height: 1.2; }
        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 150px; height: auto; }
        .title { text-align: center; }
        .title h3 { margin: 0; padding: 0; font-size: 14pt; }
        .title p { margin: 5px 0 0 0; font-size: 10pt; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; }
        .category-header { background-color: #eee; font-weight: bold; text-align: center !important; }
        .signature-table { width: 100%; margin-top: 30px; }
        .signature-box { text-align: center; width: 50%; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8pt; border-top: 1px solid #ccc; padding-top: 5px; }
        .page-break { page-break-after: always; }
        .status-check { font-family: DejaVu Sans, sans-serif; } /* Required for checkmark symbol */
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td width="30%"><img src="{{ public_path('images/logo.png') }}" class="logo"></td>
                <td width="70%" class="title">
                    <h3>INSPEKSI FASILITAS AIRPORT TECHNOLOGY</h3>
                    <p>DI BANDARA INTERNASIONAL SAMS SEPINGGAN BALIKPAPAN</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td width="20%"><b>Hari</b></td><td width="30%">: {{ $inspeksi->hari }}</td>
            <td width="20%"><b>Waktu Inspeksi</b></td>
            <td width="30%">: 
                @php $waktas = []; if($inspeksi->w1 == 'Y') $waktas[] = 'PAGI s/d SIANG'; if($inspeksi->w2 == 'Y') $waktas[] = 'SIANG s/d MALAM'; @endphp
                {{ implode(', ', $waktas) }}
            </td>
        </tr>
        <tr>
            <td><b>Tanggal</b></td><td>: {{ $inspeksi->tanggal->format('d M Y') }}</td>
            <td><b>Lokasi</b></td><td>: {{ $inspeksi->lokasi->nama }}</td>
        </tr>
        <tr>
            <td><b>Cuaca</b></td><td>: {{ $inspeksi->cuaca }}</td>
            <td></td><td></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Peralatan</th>
                <th width="10%">Jumlah</th>
                <th width="15%">Kondisi</th>
                <th width="15%">Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detailsByKategori as $katName => $details)
                <tr>
                    <td colspan="5" class="category-header">{{ strtoupper($katName) }}</td>
                </tr>
                @foreach($details as $index => $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->masterData->nama }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td style="text-align: center;">{{ $detail->kondisi_struktur }}</td>
                        <td style="text-align: center;">
                            @if($detail->foto)
                                <img src="{{ public_path('images/kondisi/' . $detail->foto) }}" width="60" style="border: 1px solid #ccc;">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td class="signature-box" style="text-align: left; vertical-align: top;">
                <b>PETUGAS INSPEKSI:</b><br><br>
                1. {{ $inspeksi->petugas1->name }} ........................<br>
                @if($inspeksi->petugas2) 2. {{ $inspeksi->petugas2->name }} ........................<br> @endif
                @if($inspeksi->petugas3) 3. {{ $inspeksi->petugas3->name }} ........................<br> @endif
                @if($inspeksi->petugas4) 4. {{ $inspeksi->petugas4->name }} ........................<br> @endif
            </td>
            <td class="signature-box">
                Diketahui:<br>
                AIRPORT TECHNOLOGY MANAGER<br><br>
                <img src="{{ public_path('images/ttdhp.png') }}" width="120"><br>
                ( HERMAN PRAYITNO )
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
