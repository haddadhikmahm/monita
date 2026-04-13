@extends('layouts.app')

@section('title', 'Status Peralatan - Monita HUD')
@section('header', 'Equipment Status & Identity')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Identity Card -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card-instrument p-8 bg-white border border-slate-100 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-aviation-900/5 -mr-16 -mt-16 rounded-full"></div>
                
                <div class="flex flex-col md:flex-row gap-8 relative z-10">
                    <div class="w-full md:w-1/3 flex flex-col items-center gap-6">
                        <div id="qr-container" class="p-4 bg-white rounded-3xl shadow-2xl border border-slate-100 group hover:scale-105 transition-transform duration-500">
                            {{-- Generate QR Code with the Full URL --}}
                            {!! QrCode::size(200)->backgroundColor(255, 255, 255)->color(0, 84, 166)->generate(route('master-data.show', $data->id)) !!}
                        </div>
                        <div class="flex flex-col items-center gap-3">
                            <div class="text-center">
                                <p class="font-mono text-aviation-900 font-bold tracking-widest text-lg">ID: {{ $data->id }}</p>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1 block">Surveillance Artifact Token</span>
                            </div>
                            <button onclick="downloadQR()" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 hover:bg-aviation-900 hover:text-white transition-all text-[9px] font-black uppercase tracking-widest">
                                <i data-lucide="download" class="w-3 h-3"></i>
                                Save Token Image
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 space-y-6">
                        <div>
                            <h3 class="text-3xl font-black text-aviation-900 tracking-tight leading-none mb-2 uppercase">{{ $data->nama }}</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 rounded-lg bg-aviation-900/10 text-aviation-900 text-[10px] font-black uppercase tracking-widest">{{ $data->kategori->nama }}</span>
                                <span class="px-3 py-1 rounded-lg bg-amber-500/10 text-amber-500 text-[10px] font-black uppercase tracking-widest">{{ $data->lokasi->nama }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Current Deployment Site</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <i data-lucide="map-pin" class="w-5 h-5 text-aviation-900"></i>
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $data->lokasi->nama }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Last Registry Update</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <i data-lucide="calendar" class="w-5 h-5 text-aviation-900"></i>
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $data->updated_at->format('d M Y - H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Status History -->
            <div class="card-instrument bg-white border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="history" class="w-4 h-4 text-aviation-900"></i>
                        <h4 class="text-xs font-black text-aviation-900 uppercase tracking-widest">Surveillance History</h4>
                    </div>
                </div>
                <div class="p-0">
                    <table class="table-hud table-hud-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Personnel</th>
                                <th>Documentation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data->inspeksiDetails()->latest()->take(5)->get() as $history)
                                <tr>
                                    <td class="text-xs font-bold text-slate-800">{{ $history->inspeksi->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        @if($history->kondisi_struktur == 'Baik')
                                            <span class="px-2 py-0.5 rounded bg-aviation-success/10 text-aviation-success text-[8px] font-black uppercase tracking-wider">Functional</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-500 text-[8px] font-black uppercase tracking-wider">Critical</span>
                                        @endif
                                    </td>
                                    <td class="font-mono text-xs">{{ $history->jumlah }} unit</td>
                                    <td class="text-xs">{{ $history->inspeksi->petugas1->name }}</td>
                                    <td class="text-center">
                                        @if($history->foto)
                                            <i data-lucide="check-circle" class="w-4 h-4 text-aviation-success mx-auto"></i>
                                        @else
                                            <i data-lucide="minus" class="w-4 h-4 text-slate-300 mx-auto"></i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400 italic text-xs">No prior inspection records available for this artifact.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Real-time Status Gauge -->
        <div class="space-y-8">
            <div class="card-instrument p-8 bg-white border border-slate-100 flex flex-col items-center justify-center text-center gap-6 relative">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] absolute top-8">System Status</p>
                
                @php $currentStatus = $data->latestInspeksiDetail?->kondisi_struktur ?? 'Unknown'; @endphp
                
                <div class="w-40 h-40 rounded-full border-[12px] flex items-center justify-center shadow-inner relative
                    {{ $currentStatus == 'Baik' ? 'border-aviation-success shadow-aviation-success/10' : ($currentStatus == 'Rusak' ? 'border-rose-500 shadow-rose-500/10' : 'border-slate-100') }}">
                    <div class="text-center">
                        <i data-lucide="{{ $currentStatus == 'Baik' ? 'shield-check' : ($currentStatus == 'Rusak' ? 'alert-octagon' : 'help-circle') }}" 
                           class="w-12 h-12 mx-auto mb-2 {{ $currentStatus == 'Baik' ? 'text-aviation-success' : ($currentStatus == 'Rusak' ? 'text-rose-500' : 'text-slate-300') }}"></i>
                        <h5 class="text-2xl font-black {{ $currentStatus == 'Baik' ? 'text-aviation-success' : ($currentStatus == 'Rusak' ? 'text-rose-500' : 'text-slate-400') }} tracking-tighter">
                            {{ $currentStatus == 'Baik' ? 'OPERATIONAL' : ($currentStatus == 'Rusak' ? 'DAMAGED' : 'UNVERIFIED') }}
                        </h5>
                    </div>
                </div>

                @if($currentStatus == 'Rusak')
                    <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl w-full">
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-1">Critical Report</p>
                        <p class="text-xs italic text-rose-700 font-semibold">"{{ $data->latestInspeksiDetail->keterangan }}"</p>
                    </div>
                @endif
                
                <div class="w-full pt-6 border-t border-slate-100 space-y-4">
                    @if($activeInspeksiId)
                        <a href="{{ route('inspeksi.category', ['kategori_id' => $data->kategori_id, 'highlight' => $data->id]) }}" class="btn-hud bg-aviation-success text-white w-full h-14 hover:scale-[1.02] shadow-xl shadow-aviation-success/20">
                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                            Mulai Update Inspeksi
                        </a>
                    @else
                        <a href="{{ route('inspeksi.create') }}" class="btn-hud bg-aviation-900 text-white w-full h-14 hover:scale-[1.02] shadow-xl shadow-aviation-900/20">
                            <i data-lucide="radar" class="w-5 h-5"></i>
                            Inisiasi Quick Inspection
                        </a>
                    @endif
                    <a href="{{ route('master-data.index') }}" class="btn-hud btn-hud-outline w-full h-12">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali ke Inventaris
                    </a>
                </div>
            </div>
            
            <button onclick="window.print()" class="btn-hud border-2 border-slate-200 text-slate-600 bg-white w-full h-12 hover:bg-slate-50">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Cetak Token Identitas
            </button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function downloadQR() {
        const svg = document.querySelector('#qr-container svg');
        const svgData = new XMLSerializer().serializeToString(svg);
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        // Increase resolution for better quality
        const scale = 4;
        canvas.width = 200 * scale;
        canvas.height = 200 * scale;
        
        img.onload = function() {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            const pngFile = canvas.toDataURL('image/png');
            const downloadLink = document.createElement('a');
            downloadLink.download = 'QR_TOKEN_{{ $data->id }}.png';
            downloadLink.href = pngFile;
            downloadLink.click();
        };
        
        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
    }
    
    lucide.createIcons();
</script>
@endsection
