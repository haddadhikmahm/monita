@extends('layouts.app')

@section('title', 'Pusat Kendali - Monita HUD')
@section('header', 'Surveillance Control Center')

@section('content')
<div class="space-y-8">
    
    <!-- Official Mission Status: Welcome & Quick Access -->
    <div class="card-instrument p-10 bg-brand-gradient text-white flex flex-col xl:flex-row items-center justify-between gap-10 shadow-2xl shadow-aviation-900/40 relative overflow-hidden group">
        <div class="radar-ping"></div> <!-- Brand Pulse -->
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            <div class="w-24 h-24 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center shadow-2xl transition-transform">
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
            <button onclick="openScanner()" class="btn-hud bg-aviation-success text-white shadow-2xl hover:scale-105 border-none">
                <i data-lucide="scan-line" class="w-4 h-4"></i> Scan QR Alat
            </button>
            <a href="{{ route('inspeksi.index') }}" class="btn-hud bg-white text-aviation-900 shadow-2xl hover:scale-105">
                <i data-lucide="radar" class="w-4 h-4"></i> Mulai Inspeksi
            </a>
            <a href="{{ route('master-data.index') }}" class="btn-hud border-2 border-white/20 text-white hover:bg-white/10 hover:border-white">
                <i data-lucide="database" class="w-4 h-4"></i> Database Alat
            </a>
        </div>
    </div>

    @include('layouts.partials.scanner')

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

    <!-- Official Tactical View: Analytics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Chart 01: Condition Doughnut -->
        <div class="card-instrument p-8 bg-white flex flex-col h-[500px]">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-aviation-success rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none">Condition Registry</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[.3em] mt-1.5">Asset Health Metrics</p>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 flex items-center justify-center p-4">
                <canvas id="conditionChart"></canvas>
            </div>
        </div>

        <!-- Chart 02: Category Distribution (Bar) -->
        <div class="card-instrument p-8 bg-white flex flex-col h-[500px]">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-aviation-900 rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none">Category Distribution</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[.3em] mt-1.5">Asset Classification</p>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 p-4">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Chart 03: Activity Trend (Line) -->
        <div class="card-instrument p-8 bg-white flex flex-col h-[500px]">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none">Operational Activity</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[.3em] mt-1.5">Monthly Inspection Trends</p>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 p-4">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Chart 04: Location Density (Horizontal Bar) -->
        <div class="card-instrument p-8 bg-white flex flex-col h-[500px]">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-rose-500 rounded-full"></div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none">Location Density</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[.3em] mt-1.5">Node Deployment Analysis</p>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 p-4">
                <canvas id="locationChart"></canvas>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Official AP Branding Palette
    const brandColors = {
        blue: '#0054A6',
        green: '#79B933',
        teal: '#00A19D',
        orange: '#F39200',
        coral: '#E95D5D',
        slate: '#64748b'
    };

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'rectRounded',
                    font: { family: '"Instrument Sans"', size: 10, weight: 'bold' },
                    color: brandColors.slate
                }
            }
        }
    };

    // 1. Condition Doughnut
    new Chart(document.getElementById('conditionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [{{ $baik }}, {{ $ringan }}, {{ $berat }}],
                backgroundColor: [brandColors.green, brandColors.orange, brandColors.coral],
                borderColor: '#ffffff',
                borderWidth: 8,
                spacing: 5
            }]
        },
        options: {
            ...commonOptions,
            cutout: '75%'
        }
    });

    // 2. Category Bar Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categories->pluck('nama')) !!},
            datasets: [{
                label: 'Total Equipment',
                data: {!! json_encode($categories->pluck('master_datas_count')) !!},
                backgroundColor: brandColors.blue,
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9 } } }
            }
        }
    });

    // 3. Activity Line Chart
    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyTrends->pluck('month')) !!},
            datasets: [{
                label: 'Inspections',
                data: {!! json_encode($monthlyTrends->pluck('total')) !!},
                borderColor: brandColors.green,
                backgroundColor: brandColors.green + '20',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#fff'
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9 } } }
            }
        }
    });

    // 4. Location Horizontal Bar
    new Chart(document.getElementById('locationChart'), {
        type: 'bar',
        indexAxis: 'y',
        data: {
            labels: {!! json_encode($locations->pluck('nama')) !!},
            datasets: [{
                label: 'Deployment Count',
                data: {!! json_encode($locations->pluck('master_datas_count')) !!},
                backgroundColor: brandColors.blue,
                borderRadius: 6,
                barThickness: 15
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 9 } } },
                y: { grid: { display: false }, ticks: { font: { size: 9 } } }
            }
        }
    });

    lucide.createIcons();

    let html5QrCode;
    let scannerIsRunning = false;

    async function openScanner() {
        if (!window.isSecureContext && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
            alert("Akses kamera hanya diperbolehkan pada koneksi aman (HTTPS) atau Localhost. Silakan gunakan HTTPS.");
            return;
        }

        const modal = document.getElementById('scannerModal');
        modal.classList.remove('hidden');
        
        try {
            const devices = await Html5Qrcode.getCameras();
            if (!devices || devices.length === 0) {
                throw new Error("Tidak ada kamera yang ditemukan pada perangkat ini.");
            }

            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };

            await html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                onScanSuccess
            );
            scannerIsRunning = true;
        } catch (err) {
            console.error(err);
            alert("Gagal: " + (err.message || "Pastikan memberikan izin kamera."));
            closeScanner();
        }
    }

    async function closeScanner() {
        document.getElementById('scannerModal').classList.add('hidden');
        if (html5QrCode && scannerIsRunning) {
            try {
                await html5QrCode.stop();
                html5QrCode.clear();
                scannerIsRunning = false;
            } catch (err) {
                console.error("Error stopping scanner:", err);
            }
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // decodedText can be a full URL (like http://127.0.0.1:8000/master-data/KD...)
        // or just the KD ID.
        
        let targetUrl = "";
        
        // If it's already a full URL in the same domain or starts with http
        if (decodedText.startsWith("http")) {
            targetUrl = decodedText;
        } 
        // If it starts with /master-data/ (relative)
        else if (decodedText.startsWith("/master-data/")) {
            targetUrl = decodedText;
        }
        // If it's just the ID
        else if (decodedText.startsWith("KD")) {
            targetUrl = `/master-data/${decodedText}`;
        } 
        else {
            alert("QR Code tidak valid atau bukan ID Peralatan MONITA.");
            return;
        }
        
        closeScanner();
        window.location.href = targetUrl;
    }
</script>
@endsection
