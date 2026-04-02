@extends('layouts.app')

@section('title', 'Edit Lokasi - Monita HUD')
@section('header', 'Protokol Modifikasi Node')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                <i data-lucide="edit-3" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Modifikasi Node Lokasi</h3>
                <p class="text-[9px] font-bold text-amber-500 uppercase tracking-[0.3em]">Update Configuration for Site: {{ $lokasi->nama }}</p>
            </div>
        </div>

        <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="form-hud-group">
                <label for="nama" class="form-hud-label">Nama Lokasi Surveillance</label>
                <input type="text" name="nama" id="nama" class="form-hud-input" 
                       placeholder="Update nama lokasi..." 
                       value="{{ old('nama', $lokasi->nama) }}" required>
                @error('nama')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="box-footer-hud">
                <a href="{{ route('lokasi.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Nodes
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
