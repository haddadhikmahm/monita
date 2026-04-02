@extends('layouts.app')

@section('title', 'Edit Personel - Monita HUD')
@section('header', 'Protokol Modifikasi Unit')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-instrument fade-up">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                <i data-lucide="edit-3" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Modifikasi Identitas Personel</h3>
                <p class="text-[9px] font-bold text-amber-500 uppercase tracking-[0.3em]">Update Authorization for Unit: {{ $user->id }}</p>
            </div>
        </div>

        <form action="{{ route('user.update', $user->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- NIK / ID -->
                <div class="form-hud-group">
                    <label for="id" class="form-hud-label">NIK / Unit Identity [HEX]</label>
                    <input type="text" name="id" id="id" class="form-hud-input bg-slate-50 cursor-not-allowed" 
                           placeholder="Masukkan NIK..." 
                           value="{{ old('id', $user->id) }}" readonly>
                    <p class="mt-2 text-[9px] text-slate-400 font-bold uppercase tracking-widest italic text-center">Unit identity is non-modifiable</p>
                </div>

                <!-- Nama Lengkap -->
                <div class="form-hud-group">
                    <label for="name" class="form-hud-label">Nama Lengkap Personel</label>
                    <input type="text" name="name" id="name" class="form-hud-input" 
                           placeholder="Masukkan nama lengkap..." 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-hud-group">
                    <label for="username" class="form-hud-label">Username [Secure Access Code]</label>
                    <input type="text" name="username" id="username" class="form-hud-input bg-slate-50 cursor-not-allowed" 
                           placeholder="Masukkan username..." 
                           value="{{ old('username', $user->username) }}" readonly>
                    <p class="mt-2 text-[9px] text-slate-400 font-bold uppercase tracking-widest italic text-center">Secure access code is non-modifiable</p>
                </div>

                <!-- Role -->
                <div class="form-hud-group">
                    <label for="role" class="form-hud-label">Clearance Level</label>
                    <select name="role" id="role" class="form-hud-select" required>
                        <option value="">-- Select Access Level --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (High Level)</option>
                        <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas (Operational)</option>
                        <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Oversight)</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-hud-group md:col-span-2">
                    <label for="password" class="form-hud-label">Password [Secure Encryption]</label>
                    <input type="password" name="password" id="password" class="form-hud-input" 
                           placeholder="Enter secure password (leave blank if no changes)...">
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
                <button type="submit" class="btn-hud btn-hud-secondary bg-aviation-900 border-none shadow-aviation-900/20">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Commit Modality
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
