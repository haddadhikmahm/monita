@extends('layouts.app')

@section('title', 'Tambah Kategori - Monita HUD')
@section('header', 'Protokol Klasifikasi Unit')

@section('content')
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                <i data-lucide="layers" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Form Klasifikasi Data</h3>
                <p class="text-[9px] font-bold text-amber-500 uppercase tracking-[0.3em]">Define New Equipment Category</p>
            </div>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="form-hud-group">
                <label for="nama" class="form-hud-label">Nama Klasifikasi / Kategori</label>
                <input type="text" name="nama" id="nama" class="form-hud-input" 
                       placeholder="Masukkan nama kategori (Contoh: Navasi Udara)" 
                       value="{{ old('nama') }}" required autofocus>
                @error('nama')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="box-footer-hud">
                <a href="{{ route('kategori.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Registry
                </a>
                <button type="submit" class="btn-hud btn-hud-primary">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Execute Protocol
                </button>
            </div>
        </form>
    </div>

@endsection
