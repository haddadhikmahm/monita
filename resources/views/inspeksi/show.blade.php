@extends('layouts.app')

@section('title', 'Detail Inspeksi - Monita HUD')
@section('header', 'Protokol Analisis Laporan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Primary Metadata -->
    <div class="lg:col-span-1 space-y-8">
        <div class="card-instrument fade-up">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                    <i data-lucide="info" class="w-5 h-5 text-aviation-900"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-800 tracking-widest uppercase">Info Metadata</h3>
                    <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Surveillance Core Data</p>
                </div>
            </div>
            <div class="p-8">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Protocol ID</span>
                        <span class="font-mono text-xs font-bold text-aviation-900">#{{ str_pad($inspeksi->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Timestamp</span>
                        <span class="text-xs font-bold text-slate-800">{{ $inspeksi->tanggal->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Oper. Day</span>
                        <span class="text-xs font-bold text-slate-800">{{ $inspeksi->hari }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Node Lokasi</span>
                        <span class="text-xs font-bold text-aviation-900">{{ $inspeksi->lokasi->nama }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Atmosfer</span>
                        <span class="px-2 py-1 rounded bg-sky-500/10 text-sky-600 text-[9px] font-black uppercase tracking-widest border border-sky-500/20">
                            {{ $inspeksi->cuaca }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Schedule</span>
                        <span class="text-xs font-bold text-slate-800">
                            {{ $inspeksi->w1 == 'Y' ? 'PAGI ' : '' }}
                            {{ $inspeksi->w1 == 'Y' && $inspeksi->w2 == 'Y' ? '| ' : '' }}
                            {{ $inspeksi->w2 == 'Y' ? 'MALAM' : '' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-instrument fade-up" style="animation-delay: 0.1s">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-aviation-success/10 flex items-center justify-center border border-aviation-success/20">
                    <i data-lucide="users" class="w-5 h-5 text-aviation-success"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-800 tracking-widest uppercase">Unit Authorized</h3>
                    <p class="text-[9px] font-bold text-aviation-success uppercase tracking-[0.3em]">Personnel In Charge</p>
                </div>
            </div>
            <div class="p-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-aviation-900 text-white flex items-center justify-center font-black text-[10px]">1</div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">{{ $inspeksi->petugas1->name }}</p>
                            <p class="text-[9px] font-black text-aviation-900 uppercase tracking-widest">Lead Unit</p>
                        </div>
                    </div>
                    @foreach(['petugas2', 'petugas3', 'petugas4'] as $idx => $field)
                        @if($inspeksi->$field)
                        <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-slate-200 text-slate-500 flex items-center justify-center font-black text-[10px]">{{ $idx + 2 }}</div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-800">{{ $inspeksi->$field->name }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Support Unit</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Matrix Analysis -->
    <div class="lg:col-span-2 space-y-8">
        <div class="card-instrument fade-up" style="animation-delay: 0.2s">
            <div class="p-8 border-b border-slate-100 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                        <i data-lucide="layers" class="w-5 h-5 text-aviation-900"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-sm text-slate-800 tracking-widest uppercase">Unit Matrix Analysis</h3>
                        <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Detailed Equipment Condition</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('inspeksi.index') }}" class="btn-hud btn-hud-outline !py-2 !px-4">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Back</span>
                    </a>
                    <a href="{{ route('inspeksi.pdf', $inspeksi->id) }}" class="btn-hud btn-hud-primary !py-2 !px-4" target="_blank">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>Print PDF</span>
                    </a>
                </div>
            </div>
            
            <div class="p-8">
                <div class="overflow-x-auto rounded-3xl border border-slate-100 shadow-sm">
                    <table class="table-hud table-hud-bordered">
                        <thead>
                            <tr>
                                <th width="10%">Hex_ID</th>
                                <th>Peralatan</th>
                                <th width="12%">Qty</th>
                                <th width="20%">Status</th>
                                <th width="15%">Visual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspeksi->details as $index => $detail)
                            <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100">
                                <td class="font-mono text-[10px] text-slate-400 text-center">#{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="font-bold text-slate-800 text-sm">{{ $detail->masterData->nama }}</td>
                                <td class="text-center font-bold text-aviation-900">{{ $detail->jumlah }}</td>
                                <td>
                                    <span class="px-2.5 py-1 rounded-full {{ $detail->kondisi_struktur == 'Baik' ? 'bg-aviation-success/10 text-aviation-success border border-aviation-success/20' : 'bg-rose-500/10 text-rose-500 border border-rose-500/20' }} text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 mx-auto">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $detail->kondisi_struktur == 'Baik' ? 'bg-aviation-success' : 'bg-rose-500' }} animate-pulse"></span>
                                        {{ $detail->kondisi_struktur }}
                                    </span>
                                </td>
                                <td>
                                    @if($detail->foto)
                                        <div class="relative group">
                                            <a href="{{ asset('images/kondisi/' . $detail->foto) }}" target="_blank" class="block w-12 h-12 mx-auto rounded-xl overflow-hidden border-2 border-slate-100 hover:border-aviation-900 transition-all shadow-sm">
                                                <img src="{{ asset('images/kondisi/' . $detail->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            </a>
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-aviation-900 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i data-lucide="zoom-in" class="w-2.5 h-2.5"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic">No Data</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
