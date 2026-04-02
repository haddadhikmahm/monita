@extends('layouts.app')

@section('title', 'Entry Inspeksi - Monita HUD')
@section('header', 'Protokol Entry Inspeksi')

@section('content')
<!-- High-End Terminal Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 z-[9999] bg-white/90 backdrop-blur-sm hidden flex-col items-center justify-center">
    <div class="relative">
        <div class="w-16 h-16 rounded-full border-4 border-slate-100 border-t-aviation-900 animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center font-black text-aviation-900 text-[10px] uppercase">UP</div>
    </div>
    <p class="mt-6 font-black text-slate-800 text-[10px] uppercase tracking-[.3em] animate-pulse">Uploading Surveillance Data...</p>
</div>

<div class="max-w-6xl mx-auto">
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="clipboard-check" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Form Laporan Inspeksi</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Operational Data Entry Protocol</p>
            </div>
        </div>

        <form action="{{ route('inspeksi.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <!-- Strategic Metadata Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="space-y-6">
                    <div class="form-hud-group">
                        <label class="form-hud-label">Hari Operasional</label>
                        <select name="hari" class="form-hud-select" required>
                            <option value="">- Select Day -</option>
                            @php $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                            @foreach($haris as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-hud-group">
                        <label class="form-hud-label">Tanggal Surveillance</label>
                        <input type="date" name="tanggal" class="form-hud-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="form-hud-group">
                        <label class="form-hud-label">Node Lokas Deployment</label>
                        <select name="lokasi_id" class="form-hud-select" required>
                            <option value="">- Select Node -</option>
                            @foreach($lokasis as $l)
                                <option value="{{ $l->id }}">{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-hud-group">
                        <label class="form-hud-label">Kondisi Atmosfer</label>
                        <select name="cuaca" class="form-hud-select">
                            <option value="Cerah">Cerah</option>
                            <option value="Berawan">Berawan</option>
                            <option value="Mendung">Mendung</option>
                            <option value="Hujan">Hujan</option>
                        </select>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200/60">
                    <label class="form-hud-label block mb-4">Waktu Inspeksi [Schedule]</label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="w1" value="Y" class="w-5 h-5 rounded-lg border-slate-200 text-aviation-900 focus:ring-aviation-900/10">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-aviation-900 transition-colors">PAGI s/d SIANG</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="w2" value="Y" class="w-5 h-5 rounded-lg border-slate-200 text-aviation-900 focus:ring-aviation-900/10">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-aviation-900 transition-colors">SIANG s/d MALAM</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Detailed Equipment Matrix -->
            <div class="space-y-12">
                @foreach($kategories as $katNama => $items)
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 px-4 border-l-4 border-aviation-900">
                            <h4 class="font-black text-xs uppercase tracking-[0.2em] text-aviation-900">{{ $katNama }}</h4>
                            <span class="text-[9px] font-bold text-slate-400">[{{ count($items) }} Units]</span>
                        </div>
                        
                        <div class="overflow-x-auto rounded-3xl border border-slate-100 shadow-sm bg-white">
                            <table class="table-hud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Peralatan</th>
                                        <th width="12%">Quantity</th>
                                        <th width="25%">Condition Status</th>
                                        <th>Visual Documentation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                        <tr class="border-b border-slate-50">
                                            <td class="text-center font-mono text-[10px] text-slate-400">{{ $loop->iteration }}</td>
                                            <td class="font-bold text-slate-800 text-sm">{{ $item->nama }}</td>
                                            <td>
                                                <input type="number" name="items[{{ $item->id }}][jml]" class="form-hud-input !py-2 !px-4 !rounded-xl !text-xs" placeholder="Qty">
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-6">
                                                    <label class="flex items-center gap-2 cursor-pointer group">
                                                        <input type="radio" name="items[{{ $item->id }}][kondisi]" value="Baik" checked 
                                                               class="w-4 h-4 border-slate-200 text-aviation-success focus:ring-aviation-success/10">
                                                        <span class="text-[10px] font-black text-slate-500 group-hover:text-aviation-success transition-colors">BAIK</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer group">
                                                        <input type="radio" name="items[{{ $item->id }}][kondisi]" value="Rusak" 
                                                               class="w-4 h-4 border-slate-200 text-rose-500 focus:ring-rose-500/10">
                                                        <span class="text-[10px] font-black text-slate-500 group-hover:text-rose-500 transition-colors">RUSAK</span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="relative group/file flex-1">
                                                        <input type="file" name="items[{{ $item->id }}][foto]" 
                                                               class="block w-full text-[10px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg- aviation-900/5 file:text-aviation-900 hover:file:bg-aviation-900/10 transition-all">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Team Clearance Allocation -->
            <div class="mt-16 pt-12 border-t border-slate-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-aviation-success/10 flex items-center justify-center border border-aviation-success/20">
                        <i data-lucide="users" class="w-5 h-5 text-aviation-success"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-sm uppercase tracking-widest text-slate-800">Unit Clearance Personnel</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Authentication of Participating Units</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="form-hud-group mb-0">
                            <label class="form-hud-label">Personnel Unit {{ $i }}</label>
                            <select name="petugas{{ $i }}_id" class="form-hud-select !py-3 !px-4" {{ $i == 1 ? 'required' : '' }}>
                                <option value="">- Select Unit -</option>
                                @foreach($petugas as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('inspeksi.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    Abort Protocol
                </a>
                <button type="submit" class="btn-hud btn-hud-primary h-14 px-10">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Submit Laporan Inspeksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('form').on('submit', function() {
            $('#loading-overlay').css('display', 'flex');
        });
    });
</script>
@endsection
