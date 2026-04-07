@extends('layouts.app')

@section('title', 'Protokol Inspeksi Baru - Monita HUD')
@section('header', 'Protokol Entry Inspeksi')

@section('content')
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="clipboard-check" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Initiate Surveillance Protocol</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Operational Metadata Entry</p>
            </div>
        </div>

        <form action="{{ route('inspeksi.start') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
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
                    <div class="form-hud-group">
                        <label class="form-hud-label">Node Lokasi Deployment</label>
                        <select name="lokasi_id" class="form-hud-select" required>
                            <option value="">- Select Node -</option>
                            @foreach($lokasis as $l)
                                <option value="{{ $l->id }}">{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="form-hud-group">
                        <label class="form-hud-label">Kondisi Atmosfer</label>
                        <select name="cuaca" class="form-hud-select">
                            <option value="Cerah">Cerah</option>
                            <option value="Berawan">Berawan</option>
                            <option value="Mendung">Mendung</option>
                            <option value="Hujan">Hujan</option>
                        </select>
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
            </div>

            <!-- Team Clearance Allocation -->
            <div class="mt-8 pt-12 border-t border-slate-100">
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
                    <span>Lanjut ke Kategori</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
