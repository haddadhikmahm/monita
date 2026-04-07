@extends('layouts.app')

@section('title', 'Tambah Lokasi - Monita HUD')
@section('header', 'Protokol Registrasi Node')

@section('content')
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="map-pin" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Form Registrasi Lokasi</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Initialize New Deployment Site</p>
            </div>
        </div>

        <form action="{{ route('lokasi.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="form-hud-group">
                <label for="nama" class="form-hud-label">Nama Lokasi Surveillance</label>
                <input type="text" name="nama" id="nama" class="form-hud-input" 
                       placeholder="Masukkan nama lokasi (Contoh: Terminal 3 Ultimate)" 
                       value="{{ old('nama') }}" required autofocus>
                @error('nama')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="box-footer-hud">
                <a href="{{ route('lokasi.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Nodes
                </a>
                <button type="submit" class="btn-hud btn-hud-primary">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Execute Registration
                </button>
            </div>
        </form>
    </div>

@endsection
