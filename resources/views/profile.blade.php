@extends('layouts.app')

@section('title', 'Profil Saya - Monita HUD')
@section('header', 'Protokol Profil Personel')

@section('content')
<div class="card-instrument fade-up">
    <!-- HUD Header with User Info -->
    <div class="p-8 border-b border-slate-100 flex items-center gap-6">
        <div class="relative group">
            <div class="w-20 h-20 rounded-2xl overflow-hidden ring-4 ring-aviation-900/10 group-hover:ring-aviation-900/20 transition-all duration-500 shadow-xl">
                <img src="{{ $user->ft ? (str_starts_with($user->ft, 'http') ? $user->ft : asset('images/' . $user->ft)) : asset('images/user.png') }}" 
                     class="w-full h-full object-cover" alt="User Photo">
            </div>
            <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-aviation-900 text-white flex items-center justify-center shadow-lg border-2 border-white">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
            </div>
        </div>
        
        <div>
            <h3 class="font-black text-xl text-slate-800 tracking-widest uppercase">{{ $user->name }}</h3>
            <p class="text-[10px] font-bold text-aviation-900 uppercase tracking-[0.4em] mt-1">{{ $user->role }} Access Clearance | Node ID: #{{ $user->id }}</p>
        </div>
    </div>

    <!-- HUD Profile Form -->
    <form action="{{ route('profile.update') }}" method="POST" class="p-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Full Name -->
            <div class="form-hud-group">
                <label for="name" class="form-hud-label">Nama Lengkap [Legal Identity]</label>
                <input type="text" name="name" id="name" class="form-hud-input" 
                       value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username / System Identity -->
            <div class="form-hud-group">
                <label for="username" class="form-hud-label">System Identity [Locked]</label>
                <input type="text" id="username" class="form-hud-input bg-slate-50 cursor-not-allowed" 
                       value="{{ $user->username }}" readonly disabled>
                <p class="mt-2 text-[9px] text-slate-400 font-bold uppercase tracking-widest italic">Identity code cannot be modified</p>
            </div>

            <!-- Email -->
            <div class="form-hud-group">
                <label for="email" class="form-hud-label">Email Communications</label>
                <input type="email" name="email" id="email" class="form-hud-input" 
                       value="{{ old('email', $user->email) }}" placeholder="your-email@example.com">
                @error('email')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="form-hud-group">
                <label for="telp" class="form-hud-label">Signal Frequency [Phone]</label>
                <input type="text" name="telp" id="telp" class="form-hud-input" 
                       value="{{ old('telp', $user->telp) }}" placeholder="Enter phone number...">
                @error('telp')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="form-hud-group md:col-span-2">
                <label for="alm" class="form-hud-label">Deployment Base [Address]</label>
                <textarea name="alm" id="alm" rows="3" class="form-hud-input resize-none" 
                          placeholder="Enter current address...">{{ old('alm', $user->alm) }}</textarea>
                @error('alm')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Divider -->
            <div class="md:col-span-2 border-t border-slate-100 my-4 flex items-center gap-4">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.5em] bg-white pr-4">Security Protocol Update</span>
            </div>

            <!-- Password Change -->
            <div class="form-hud-group">
                <label for="password" class="form-hud-label">New Access Code [Empty to keep current]</label>
                <input type="password" name="password" id="password" class="form-hud-input" 
                       placeholder="Enter new secure password...">
                @error('password')
                    <p class="mt-2 text-[10px] font-bold text-aviation-danger uppercase tracking-wider">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-hud-group">
                <label for="password_confirmation" class="form-hud-label">Confirm New Access Code</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-hud-input" 
                       placeholder="Retype password for confirmation...">
            </div>
        </div>

        <div class="box-footer-hud">
            <button type="submit" class="btn-hud btn-hud-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Commit Registry Update
            </button>
        </div>
    </form>
</div>
@endsection
