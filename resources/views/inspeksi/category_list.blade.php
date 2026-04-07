@extends('layouts.app')

@section('title', 'Kategori Inspeksi - Monita HUD')
@section('header', 'Pilih Kategori Surveillance')

@section('content')
    <div class="space-y-8 fade-up">
        <!-- Status Banner -->
        <div class="card-instrument p-6 border-l-4 border-aviation-900 bg-aviation-900/5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-aviation-900 flex items-center justify-center text-white">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="font-black text-xs uppercase tracking-widest text-aviation-900">Active Session: {{ $inspeksi->id }}</h4>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        Node: {{ $inspeksi->lokasi->nama }} | Date: {{ $inspeksi->tanggal->format('d M Y') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @php $allDone = $kategories->every(fn($k) => $k->is_complete); @endphp
                @if($allDone)
                    <span class="px-4 py-2 rounded-xl bg-aviation-success text-white text-[10px] font-black uppercase tracking-widest animate-pulse">
                        READY FOR SUBMISSION
                    </span>
                @else
                    <span class="px-4 py-2 rounded-xl bg-slate-200 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                        PENDING DATA ENTRY
                    </span>
                @endif
            </div>
        </div>

        <!-- Category Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($kategories as $kat)
                <a href="{{ route('inspeksi.category', $kat->id) }}" class="group">
                    <div class="card-instrument p-8 h-full border-b-4 {{ $kat->is_complete ? 'border-aviation-success bg-aviation-success/5' : 'border-slate-200 hover:border-aviation-900' }} transition-all duration-300">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 rounded-2xl {{ $kat->is_complete ? 'bg-aviation-success/10 text-aviation-success' : 'bg-slate-100 text-slate-400 group-hover:bg-aviation-900/10 group-hover:text-aviation-900' }} flex items-center justify-center transition-colors">
                                <i data-lucide="{{ $kat->is_complete ? 'check-circle-2' : 'package' }}" class="w-6 h-6"></i>
                            </div>
                            @if($kat->is_complete)
                                <div class="px-3 py-1 rounded-full bg-aviation-success text-white text-[8px] font-black uppercase tracking-tighter">
                                    COMPLETED
                                </div>
                            @endif
                        </div>
                        
                        <h4 class="font-black text-sm uppercase tracking-widest text-slate-800 mb-2 group-hover:text-aviation-900 transition-colors">
                            {{ $kat->nama }}
                        </h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                            Inspeksi peralatan operasional untuk kategori {{ $kat->nama }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Action Footer -->
        <div class="flex justify-between items-center mt-12 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <form action="{{ route('inspeksi.finish') }}" method="POST">
                @csrf
                <button type="submit" class="btn-hud btn-hud-primary h-14 px-10 {{ $allDone ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $allDone ? '' : 'disabled' }}>
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>Finalize & Submit Report</span>
                </button>
            </form>

            <a href="{{ route('inspeksi.index') }}" class="text-[10px] font-black text-rose-500 uppercase tracking-[0.3em] hover:underline">
                Discard Session [Emergency Abort]
            </a>
        </div>
    </div>
@endsection
