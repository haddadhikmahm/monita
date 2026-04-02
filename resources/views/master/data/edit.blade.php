@extends('layouts.app')

@section('title', 'Edit Peralatan - Monita HUD')
@section('header', 'Protokol Modifikasi Unit')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                <i data-lucide="edit-3" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Modifikasi Identitas Alat</h3>
                <p class="text-[9px] font-bold text-amber-500 uppercase tracking-[0.3em]">Update Configuration for Unit: {{ $data->id }}</p>
            </div>
        </div>

        <form action="{{ route('master-data.update', $data->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-8">
                <!-- Nama Peralatan -->
                <div class="form-hud-group">
                    <label for="nama" class="form-hud-label">Nama Peralatan Surveillance</label>
                    <input type="text" name="nama" id="nama" class="form-hud-input" 
                           placeholder="Update nama unit..." 
                           value="{{ old('nama', $data->nama) }}" required>
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
                                <option value="{{ $k->id }}" {{ old('kategori_id', $data->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
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
                                <option value="{{ $l->id }}" {{ old('lokasi_id', $data->lokasi_id) == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
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
                <button type="submit" class="btn-hud btn-hud-secondary bg-aviation-900 border-none shadow-aviation-900/20">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Commit Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
