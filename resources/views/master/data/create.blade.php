@extends('layouts.app')

@section('title', 'Tambah Peralatan - Monita HUD')
@section('header', 'Protokol Registrasi Alat')

@section('content')
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="package-plus" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Form Registrasi Alat</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Initialize New Surveillance Node</p>
            </div>
        </div>

        <form action="{{ route('master-data.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 gap-8">
                <!-- Nama Peralatan -->
                <div class="form-hud-group">
                    <label for="nama" class="form-hud-label">Nama Peralatan Surveillance</label>
                    <input type="text" name="nama" id="nama" class="form-hud-input" 
                           placeholder="Masukkan nama unit (Contoh: Sensor Radar X1)" 
                           value="{{ old('nama') }}" required autofocus>
                    @error('nama')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kategori -->
                    <div class="form-hud-group">
                        <label for="kategori_id" class="form-hud-label">Klasifikasi Unit</label>
                        <select name="kategori_id" id="kategori_id" class="form-hud-select" required>
                            <option value="">-- Select Classification --</option>
                            @foreach($kategories as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="form-hud-group">
                        <label for="lokasi_id" class="form-hud-label">Node Lokasi Deployment</label>
                        <select name="lokasi_id" id="lokasi_id" class="form-hud-select" required>
                            <option value="">-- Select Deployment Node --</option>
                            @foreach($lokasis as $l)
                                <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                            @endforeach
                        </select>
                        @error('lokasi_id')
                            <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="box-footer-hud">
                <a href="{{ route('master-data.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Registry
                </a>
                <button type="submit" class="btn-hud btn-hud-primary">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Execute Registration
                </button>
            </div>
        </form>
    </div>

@endsection
