@extends('layouts.app')

@section('title', 'Rekap Laporan - Monita HUD')
@section('header', 'Protokol Rekapitulasi Surveillance')

@section('content')
<div class="card-instrument fade-up">
    <!-- HUD Header -->
    <div class="p-8 border-b border-slate-100 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="calendar-check" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Master Rekapitulasi</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Aggregate Historical Operational Data</p>
            </div>
        </div>
    </div>

    <!-- HUD Table Content -->
    <div class="p-8 overflow-x-auto">
        <table id="rekapHudTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="5%">SEQ</th>
                    <th>Timestamp</th>
                    <th>Oper. Day</th>
                    <th>Node Lokasi</th>
                    <th>Atmosfer</th>
                    <th>Status Matriks Alat</th>
                    <th width="10%">Analisis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inspeksis as $i)
                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100">
                    <td class="font-mono text-xs text-slate-400 text-center">{{ $loop->iteration }}</td>
                    <td class="font-bold text-slate-800 tracking-wide text-xs">{{ $i->tanggal->format('d F Y') }}</td>
                    <td class="text-xs font-semibold uppercase tracking-widest text-slate-500">{{ $i->hari }}</td>
                    <td class="font-bold text-aviation-900 text-sm">{{ $i->lokasi->nama }}</td>
                    <td>
                        <span class="px-2 py-1 rounded bg-sky-500/10 text-sky-600 text-[9px] font-black uppercase tracking-widest border border-sky-500/20">
                            {{ $i->cuaca }}
                        </span>
                    </td>
                    <td>
                        @php
                            $rusak = $i->details->where('kondisi_struktur', 'Rusak')->count();
                            $baik = $i->details->where('kondisi_struktur', 'Baik')->count();
                        @endphp
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full bg-aviation-success/10 text-aviation-success border border-aviation-success/20 text-[9px] font-black uppercase tracking-widest">
                                {{ $baik }} OK
                            </span>
                            @if($rusak > 0)
                                <span class="px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-500 border border-rose-500/20 text-[9px] font-black uppercase tracking-widest">
                                    {{ $rusak }} ERR
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('inspeksi.show', $i->id) }}" class="p-2 rounded-xl bg-aviation-900/10 text-aviation-900 border border-aviation-900/20 hover:bg-aviation-900 hover:text-white transition-all shadow-lg hover:shadow-aviation-900/20 flex items-center justify-center gap-2 group" title="Open Analysis">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <span class="text-[10px] font-black uppercase group-hover:block hidden">View</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function () {
        $('#rekapHudTable').DataTable({
            "order": [[1, "desc"]],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Aggregate Logs...",
                "lengthMenu": "Show _MENU_ Records",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
