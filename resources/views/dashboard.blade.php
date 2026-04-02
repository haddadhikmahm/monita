@extends('layouts.app')

@section('title', 'Pusat Kendali - Monita HUD')
@section('header', 'Surveillance Control Center')

@section('content')
<div class="space-y-8">
    
    <!-- Official Mission Status: Welcome & Quick Access -->
    <div class="card-instrument p-10 bg-brand-gradient text-white flex flex-col xl:flex-row items-center justify-between gap-10 shadow-2xl shadow-aviation-900/40 relative overflow-hidden group">
        <div class="radar-ping"></div> <!-- Brand Pulse -->
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            <div class="w-24 h-24 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center animate-float shadow-2xl group-hover:rotate-6 transition-transform">
                <i data-lucide="tower-control" class="w-12 h-12 text-aviation-success"></i>
            </div>
            <div>
                <h2 class="text-3xl font-black tracking-tight">Selamat Datang, {{ Auth::user()->name }}</h2>
                <div class="flex items-center justify-center md:justify-start gap-4 mt-3">
                    <span class="px-3 py-1.5 rounded-xl bg-aviation-success text-[10px] font-black uppercase tracking-[.2em] shadow-lg shadow-aviation-success/20">System Ready</span>
                    <span class="w-[1px] h-4 bg-white/20"></span>
                    <p class="text-sky-100 font-bold text-sm tracking-wide opacity-80 italic">Authorized Access: Sepinggan Command Terminal</p>
                </div>
            </div>
        </div>
        <div class="relative z-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('inspeksi.index') }}" class="btn-hud bg-white text-aviation-900 shadow-2xl hover:scale-105">
                <i data-lucide="radar" class="w-4 h-4"></i> Mulai Inspeksi
            </a>
            <a href="{{ route('master-data.index') }}" class="btn-hud border-2 border-white/20 text-white hover:bg-white/10 hover:border-white">
                <i data-lucide="database" class="w-4 h-4"></i> Database Alat
            </a>
        </div>
    </div>

    <!-- Official Statistic Instrument Clusters -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
        <!-- Cluster 01: Total Equipment -->
        <div class="card-instrument hover:-translate-y-2 group">
            <div class="p-8 flex flex-col gap-6">
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 rounded-2xl bg-aviation-900/5 group-hover:bg-aviation-900/10 flex items-center justify-center transition-all duration-500 border border-aviation-900/5">
                        <i data-lucide="package" class="w-7 h-7 text-aviation-900"></i>
                    </div>
                    <span class="text-[9px] font-black text-aviation-900 tracking-[.3em] uppercase">Module.01</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-800 tracking-tighter">{{ $countData }}</p>
                    <h4 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 mt-2">Total Inventaris Alat</h4>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-aviation-900 h-full w-[85%] rounded-full shadow-[0_0_8px_rgba(0,84,166,0.3)]"></div>
                </div>
            </div>
        </div>

        <!-- Cluster 02: Deployment Locations -->
        <div class="card-instrument hover:-translate-y-2 group">
            <div class="p-8 flex flex-col gap-6">
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 rounded-2xl bg-aviation-success/5 group-hover:bg-aviation-success/10 flex items-center justify-center transition-all duration-500 border border-aviation-success/5">
                        <i data-lucide="map-pin" class="w-7 h-7 text-aviation-success"></i>
                    </div>
                    <span class="text-[9px] font-black text-aviation-success tracking-[.3em] uppercase">Module.02</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-800 tracking-tighter">{{ $countLokasi }}</p>
                    <h4 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 mt-2">Titik Lokasi Node</h4>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-aviation-success h-full w-[65%] rounded-full shadow-[0_0_8px_#79B933]"></div>
                </div>
            </div>
        </div>

        <!-- Cluster 03: Active Personnel -->
        <div class="card-instrument hover:-translate-y-2 group">
            <div class="p-8 flex flex-col gap-6">
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/5 group-hover:bg-amber-500/10 flex items-center justify-center transition-all duration-500 border border-amber-500/5">
                        <i data-lucide="users" class="w-7 h-7 text-amber-500"></i>
                    </div>
                    <span class="text-[9px] font-black text-amber-500 tracking-[.3em] uppercase">Module.03</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-800 tracking-tighter">{{ $countUser }}</p>
                    <h4 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 mt-2">Unit Personel Aktif</h4>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full w-[92%] rounded-full shadow-[0_0_8px_rgba(245,158,11,0.3)]"></div>
                </div>
            </div>
        </div>

        <!-- Cluster 04: Log Activity -->
        <div class="card-instrument hover:-translate-y-2 group">
            <div class="p-8 flex flex-col gap-6">
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/5 group-hover:bg-rose-500/10 flex items-center justify-center transition-all duration-500 border border-rose-500/5">
                        <i data-lucide="activity" class="w-7 h-7 text-rose-500"></i>
                    </div>
                    <span class="text-[9px] font-black text-rose-500 tracking-[.3em] uppercase">Module.04</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-800 tracking-tighter">100%</p>
                    <h4 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 mt-2">Status Konektivitas</h4>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-rose-500 h-full w-full rounded-full shadow-[0_0_8px_rgba(239,68,68,0.3)] animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Official Tactical View: Condition Analysis -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Condition Chart HUD -->
        <div class="xl:col-span-2 card-instrument p-10 bg-white">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-8 bg-aviation-900 rounded-full"></div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest leading-none">Analisis Kelayakan Alat</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[.3em] mt-2 leading-none">Condition Monitoring Metrics</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-aviation-900"></span>
                        <span class="text-[9px] font-black uppercase text-slate-500">Live Telemetry</span>
                    </div>
                </div>
            </div>
            
            <div class="relative h-[400px] flex items-center justify-center">
                <!-- Instrument Chart Render -->
                <canvas id="conditionChart"></canvas>
            </div>
        </div>

        <!-- System Log HUD -->
        <div class="card-instrument bg-slate-50 overflow-hidden border-2 border-slate-200/40">
            <div class="p-8 border-b border-slate-200 bg-white flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-aviation-900 uppercase tracking-widest">Protocol Stats</h3>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Data Summary</p>
                </div>
                <i data-lucide="info" class="w-4 h-4 text-slate-400"></i>
            </div>
            <div class="p-8 space-y-8">
                <div class="space-y-6">
                    <!-- Stat 01 -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-aviation-900/5 flex items-center justify-center border border-aviation-900/10">
                                <i data-lucide="cpu" class="w-5 h-5 text-aviation-900"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Database Size</p>
                                <p class="text-xs font-black text-aviation-900 mt-1">128.4 MB / 1 GB</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono text-aviation-900 font-bold">12%</span>
                    </div>

                    <!-- Stat 02 -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-aviation-success/5 flex items-center justify-center border border-aviation-success/10">
                                <i data-lucide="wifi" class="w-5 h-5 text-aviation-success"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Bandwidth Usage</p>
                                <p class="text-xs font-black text-aviation-success mt-1">2.4 Gbps</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono text-aviation-success font-bold">Optimal</span>
                    </div>

                    <!-- Stat 03 -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/5 flex items-center justify-center border border-amber-500/10">
                                <i data-lucide="refresh-cw" class="w-5 h-5 text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Auto Sync Rate</p>
                                <p class="text-xs font-black text-amber-500 mt-1">5m Interval</p>
                            </div>
                        </div>
                        <i data-lucide="check-circle" class="w-4 h-4 text-aviation-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('conditionChart').getContext('2d');
    
    // Official AP Branding Palette
    const brandColors = {
        blue: '#0054A6',
        green: '#79B933',
        teal: '#00A19D',
        orange: '#F39200',
        coral: '#E95D5D'
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [{{ $baik }}, {{ $ringan }}, {{ $berat }}],
                backgroundColor: [brandColors.green, brandColors.orange, brandColors.coral],
                borderColor: '#ffffff',
                borderWidth: 10,
                hoverOffset: 20,
                spacing: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 30,
                        usePointStyle: true,
                        pointStyle: 'rectRounded',
                        font: {
                            family: '"Instrument Sans"',
                            size: 11,
                            weight: 'bold'
                        },
                        color: '#64748b'
                    }
                }
            }
        }
    });

    // Re-init lucide icons for dynamic items
    lucide.createIcons();
</script>
@endsection
