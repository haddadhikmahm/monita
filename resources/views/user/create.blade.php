@extends('layouts.app')

@section('title', 'Tambah Personel - Monita HUD')
@section('header', 'Protokol Clearance Unit')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="user-plus" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Form Clearance Personel</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Authorize New Operational Unit</p>
            </div>
        </div>

        <form action="{{ route('user.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- NIK / ID -->
                <div class="form-hud-group">
                    <label for="id" class="form-hud-label">NIK / Unit Identity [HEX]</label>
                    <input type="text" name="id" id="id" class="form-hud-input" 
                           placeholder="Masukkan NIK..." 
                           value="{{ old('id') }}" required autofocus>
                    @error('id')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="form-hud-group">
                    <label for="name" class="form-hud-label">Nama Lengkap Personel</label>
                    <input type="text" name="name" id="name" class="form-hud-input" 
                           placeholder="Masukkan nama lengkap..." 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-hud-group">
                    <label for="username" class="form-hud-label">Username [Secure Access Code]</label>
                    <input type="text" name="username" id="username" class="form-hud-input" 
                           placeholder="Masukkan username..." 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="form-hud-group">
                    <label for="role" class="form-hud-label">Clearance Level</label>
                    <select name="role" id="role" class="form-hud-select" required>
                        <option value="">-- Select Access Level --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (High Level)</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas (Operational)</option>
                        <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Oversight)</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-hud-group md:col-span-2">
                    <label for="password" class="form-hud-label">Password [Secure Encryption]</label>
                    <input type="password" name="password" id="password" class="form-hud-input" 
                           placeholder="Enter secure password..." 
                           required>
                    @error('password')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="box-footer-hud">
                <a href="{{ route('user.index') }}" class="btn-hud btn-hud-outline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Unit Registry
                </a>
                <button type="submit" class="btn-hud btn-hud-primary">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Execute Authorization
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
