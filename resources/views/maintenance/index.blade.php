@extends('layouts.app')

@section('title', 'Maintenance Log - Monita HUD')
@section('header', 'Maintenance surveillance Terminal')

@section('content')
@if(session('success'))
    <div class="mb-6 p-4 bg-aviation-success/10 border border-aviation-success/20 rounded-2xl flex items-center gap-3 text-aviation-success fade-up">
        <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
        <span class="text-xs font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="card-instrument fade-up">
    <!-- HUD Header with Strategic Summary -->
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center border border-rose-500/20">
                <i data-lucide="wrench" class="w-6 h-6 text-rose-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Maintenance Queue</h3>
                <p class="text-[9px] font-bold text-rose-500 uppercase tracking-[0.3em]">Critical Equipment Restoration Log</p>
            </div>
        </div>

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'pimpinan')
            <div class="flex items-center gap-4">
                <div class="px-6 py-3 bg-rose-50 border border-rose-100 rounded-2xl flex flex-col items-end">
                    <span class="text-[8px] font-black text-rose-400 uppercase tracking-widest leading-none mb-1.5">Critical Backlog</span>
                    <span class="text-xl font-bold text-rose-600 tracking-tighter">{{ $maintenanceItems->where('is_repaired', false)->count() }} ALAT</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Advanced Logic Filter Console -->
    <div class="p-8 bg-slate-50/50 border-b border-slate-100">
        <form action="{{ route('maintenance.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Time Horizon</label>
                <select name="period" class="form-hud-select !py-2 !text-xs">
                    <option value="">- All Time -</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Harian [Today]</option>
                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Mingguan [This Week]</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulanan [This Month]</option>
                    <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahunan [This Year]</option>
                </select>
            </div>
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Custom Range [Start]</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-hud-input !py-2 !text-xs">
            </div>
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Custom Range [End]</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-hud-input !py-2 !text-xs">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-hud btn-hud-primary !py-2 !h-10 flex-1">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Execute Filter</span>
                </button>
                <a href="{{ route('maintenance.index') }}" class="btn-hud btn-hud-outline !py-2 !h-10 flex items-center justify-center">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Asset Category</label>
                <select name="kategori_id" class="form-hud-select !py-2 !text-xs" onchange="this.form.submit()">
                    <option value="">- All Categories -</option>
                    @foreach($kategories as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Specific Equipment [Alat]</label>
                <select name="data_id" class="form-hud-select !py-2 !text-xs" onchange="this.form.submit()">
                    <option value="">- All Equipment -</option>
                    @foreach($all_alat as $alat)
                        <option value="{{ $alat->id }}" {{ request('data_id') == $alat->id ? 'selected' : '' }}>[{{ $alat->kategori->nama ?? 'N/A' }}] {{ $alat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Deployment Node</label>
                <select name="lokasi_id" class="form-hud-select !py-2 !text-xs" onchange="this.form.submit()">
                    <option value="">- All Nodes -</option>
                    @foreach($lokasis as $lok)
                        <option value="{{ $lok->id }}" {{ request('lokasi_id') == $lok->id ? 'selected' : '' }}>{{ $lok->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-hud-group mb-0">
                <label class="form-hud-label !text-[8px]">Status Perbaikan</label>
                <select name="status_perbaikan" class="form-hud-select !py-2 !text-xs" onchange="this.form.submit()">
                    <option value="">- Semua Status -</option>
                    <option value="pending" {{ request('status_perbaikan') == 'pending' ? 'selected' : '' }}>Belum Diperbaiki [Pending]</option>
                    <option value="repaired" {{ request('status_perbaikan') == 'repaired' ? 'selected' : '' }}>Sudah Diperbaiki [Selesai]</option>
                </select>
            </div>
        </form>
    </div>

    <!-- HUD Table Content -->
    <div class="p-8 overflow-x-auto">
        <table id="maintenanceHudTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Alat</th>
                    <th>Node Lokasi</th>
                    <th width="20%">Keterangan Kerusakan</th>
                    <th width="15%">Visual Documentation</th>
                    <th>Reported At</th>
                    <th>Status Perbaikan</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenanceItems as $item)
                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100">
                    <td class="text-center font-mono text-[10px] text-slate-400">{{ $loop->iteration }}</td>
                    <td class="font-bold text-slate-800 tracking-wide text-xs">
                        {{ $item->masterData->nama }}
                        <span class="block text-[8px] text-slate-400 uppercase tracking-widest mt-1">
                            {{ $item->masterData->kategori->nama }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-aviation-900"></i>
                            <span class="text-sm font-semibold">{{ $item->inspeksi->lokasi->nama }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-rose-600 bg-rose-50 p-3 rounded-xl border border-rose-100">
                                {{ $item->keterangan ?? 'No specific description provided.' }}
                            </p>
                            @if($item->is_repaired && $item->keterangan_perbaikan)
                                <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-xl">
                                    <span class="text-[8px] font-black text-emerald-600 uppercase tracking-wider block mb-1">Catatan Perbaikan:</span>
                                    <p class="text-xs font-semibold text-emerald-800">
                                        {{ $item->keterangan_perbaikan }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="flex gap-4 items-center justify-center">
                            @if($item->foto)
                                <div class="flex flex-col items-center">
                                    <span class="text-[7px] font-black text-rose-500 uppercase tracking-widest mb-0.5">Kerusakan</span>
                                    <a href="{{ asset('images/kondisi/' . $item->foto) }}" target="_blank" class="block w-16 h-10 rounded-lg overflow-hidden border border-slate-200 group">
                                        <img src="{{ asset('images/kondisi/' . $item->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="Damage Doc">
                                    </a>
                                </div>
                            @else
                                <div class="w-16 h-10 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-[7px] font-black uppercase text-slate-300">
                                    No Foto
                                </div>
                            @endif

                            @if($item->foto_perbaikan)
                                <div class="flex flex-col items-center">
                                    <span class="text-[7px] font-black text-emerald-600 uppercase tracking-widest mb-0.5">Perbaikan</span>
                                    <a href="{{ asset('images/kondisi/' . $item->foto_perbaikan) }}" target="_blank" class="block w-16 h-10 rounded-lg overflow-hidden border border-slate-200 group">
                                        <img src="{{ asset('images/kondisi/' . $item->foto_perbaikan) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="Repair Doc">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800">{{ $item->inspeksi->tanggal->format('d/m/Y') }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">
                                {{ $item->created_at->format('H:i') }} hrs
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="text-center space-y-1">
                            @if($item->is_repaired)
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 mx-auto w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Selesai
                                </span>
                                @if($item->kondisi_perbaikan)
                                    <span class="block text-[8px] text-slate-400 uppercase tracking-widest font-black leading-none mt-1">
                                        Kondisi: {{ $item->kondisi_perbaikan }}
                                    </span>
                                @endif
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-500 border border-rose-500/20 text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 mx-auto w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                    Pending
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if(Auth::user()->role != 'pimpinan')
                            <button type="button" 
                                    onclick="openRepairModal({{ json_encode([
                                        'id' => $item->id,
                                        'nama_alat' => $item->masterData->nama,
                                        'kategori' => $item->masterData->kategori->nama ?? 'N/A',
                                        'lokasi' => $item->inspeksi->lokasi->nama ?? 'N/A',
                                        'keterangan_rusak' => $item->keterangan ?? '-',
                                        'foto_rusak' => $item->foto ? asset('images/kondisi/' . $item->foto) : null,
                                        'is_repaired' => $item->is_repaired,
                                        'kondisi_perbaikan' => $item->kondisi_perbaikan,
                                        'keterangan_perbaikan' => $item->keterangan_perbaikan,
                                        'foto_perbaikan' => $item->foto_perbaikan ? asset('images/kondisi/' . $item->foto_perbaikan) : null,
                                        'tgl_perbaikan' => $item->tgl_perbaikan ? $item->tgl_perbaikan->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')
                                    ]) }})"
                                    class="p-2 rounded-xl bg-amber-500/10 text-amber-600 border border-amber-500/20 hover:bg-amber-500 hover:text-white transition-all shadow-lg hover:shadow-amber-500/20 flex items-center justify-center gap-2 group w-full"
                                    title="Log Perbaikan">
                                <i data-lucide="wrench" class="w-4 h-4"></i>
                                <span class="text-[10px] font-black uppercase">Perbaikan</span>
                            </button>
                        @else
                            <span class="text-xs text-slate-400 italic font-semibold block text-center">View Only</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Beautiful HUD-Style Repair Modal -->
<div id="repairModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-slate-100 bg-brand-gradient flex items-center justify-between">
            <div class="flex items-center gap-3 text-white">
                <i data-lucide="wrench" class="w-6 h-6"></i>
                <div>
                    <h3 class="font-black text-sm tracking-widest uppercase">Maintenance Repair Console</h3>
                    <p class="text-[8px] font-bold text-aviation-success uppercase tracking-[0.3em]">Hardware Rectification Log</p>
                </div>
            </div>
            <button type="button" onclick="closeRepairModal()" class="text-white/60 hover:text-white transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="repairForm" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
            @csrf
            
            <!-- Tool Information Banner -->
            <div class="grid grid-cols-3 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <div class="flex flex-col">
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Equipment Name</span>
                    <span id="modalAlatName" class="text-xs font-bold text-slate-800 mt-1">-</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Category</span>
                    <span id="modalAlatKategori" class="text-xs font-bold text-slate-800 mt-1">-</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Deployment Node</span>
                    <span id="modalAlatLokasi" class="text-xs font-bold text-aviation-900 mt-1">-</span>
                </div>
            </div>

            <!-- Before Status (Original Damage Details) -->
            <div class="border border-rose-100 bg-rose-50/20 p-4 rounded-2xl">
                <h4 class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] mb-3 flex items-center gap-1.5">
                    <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                    Initial Malfunction Log [Damage]
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <div class="md:col-span-2">
                        <span class="text-[8px] font-black text-rose-400 uppercase tracking-widest">Damage Notes</span>
                        <p id="modalKeteranganRusak" class="text-xs font-bold text-rose-700 bg-rose-50/50 p-3 rounded-xl border border-rose-100 mt-1.5 leading-relaxed">
                            -
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-[8px] font-black text-rose-400 uppercase tracking-widest mb-1.5">Damage Visual</span>
                        <div id="modalDamagePhotoContainer" class="w-full h-24 rounded-xl border border-rose-100 bg-white overflow-hidden flex items-center justify-center">
                            <span class="text-[8px] font-bold text-rose-300 uppercase">No Photo</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- After Status (Repair Log Form) -->
            <div class="space-y-6">
                <h4 class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-2 flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    Rectification Parameters [Repair Input]
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-hud-group mb-0">
                        <label class="form-hud-label !text-[8px]">Kondisi Setelah Perbaikan</label>
                        <div class="flex items-center gap-6 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="kondisi_perbaikan" value="Baik" required
                                       class="w-4 h-4 border-slate-200 text-aviation-success focus:ring-aviation-success/10">
                                <span class="text-[10px] font-black text-slate-500 group-hover:text-slate-800 transition-colors">BAIK [REPAIRED]</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="kondisi_perbaikan" value="Tidak Baik" required
                                       class="w-4 h-4 border-slate-200 text-rose-500 focus:ring-rose-500/10">
                                <span class="text-[10px] font-black text-slate-500 group-hover:text-slate-800 transition-colors">TIDAK BAIK [STILL DAMAGED]</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-hud-group mb-0">
                        <label class="form-hud-label !text-[8px]">Tanggal & Jam Perbaikan</label>
                        <input type="datetime-local" name="tgl_perbaikan" required
                               class="form-hud-input !py-2 !text-xs mt-1">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    <div class="md:col-span-2 form-hud-group mb-0">
                        <label class="form-hud-label !text-[8px]">Keterangan Perbaikan</label>
                        <textarea name="keterangan_perbaikan" rows="3" required
                                  placeholder="Jelaskan tindakan perbaikan yang telah dilakukan..."
                                  class="form-hud-input !py-2 !px-3 !rounded-2xl !text-xs mt-1.5"></textarea>
                    </div>

                    <div class="form-hud-group mb-0">
                        <label class="form-hud-label !text-[8px]">Bukti Foto Perbaikan</label>
                        <input type="file" name="foto_perbaikan" accept="image/*"
                               class="block w-full text-[9px] text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-aviation-success/10 file:text-aviation-success mt-1.5">
                        <div id="modalExistingRepairPhotoContainer" class="mt-2 hidden">
                            <span class="text-[7px] font-black text-slate-400 uppercase tracking-widest block mb-1">Current Proof:</span>
                            <div class="w-16 h-10 rounded-lg overflow-hidden border border-slate-200">
                                <img id="modalExistingRepairPhoto" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action Controls -->
            <div class="p-6 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 -mx-6 -mb-6">
                <button type="button" onclick="closeRepairModal()" class="btn-hud btn-hud-outline !py-2">
                    <span>Cancel</span>
                </button>
                <button type="submit" class="btn-hud btn-hud-primary !py-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Save Repair Log</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function () {
        $('#maintenanceHudTable').DataTable({
            "order": [[0, "asc"]],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Maintenance Log...",
                "lengthMenu": "Display _MENU_ Records",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });

    function openRepairModal(data) {
        const modal = document.getElementById('repairModal');
        const content = modal.querySelector('div');
        
        // Fill text info
        document.getElementById('modalAlatName').textContent = data.nama_alat;
        document.getElementById('modalAlatKategori').textContent = data.kategori;
        document.getElementById('modalAlatLokasi').textContent = data.lokasi;
        document.getElementById('modalKeteranganRusak').textContent = data.keterangan_rusak;
        
        // Original photo
        const damageContainer = document.getElementById('modalDamagePhotoContainer');
        if (data.foto_rusak) {
            damageContainer.innerHTML = `<a href="${data.foto_rusak}" target="_blank" class="w-full h-full block"><img src="${data.foto_rusak}" class="w-full h-full object-cover hover:scale-105 transition-transform" /></a>`;
        } else {
            damageContainer.innerHTML = `<span class="text-[8px] font-bold text-rose-300 uppercase">No Photo</span>`;
        }
        
        // Form action
        const form = document.getElementById('repairForm');
        form.action = "{{ route('maintenance.repair', ':id') }}".replace(':id', data.id);
        
        // Fill repair fields if exists
        form.querySelector(`input[name="kondisi_perbaikan"][value="Baik"]`).checked = data.is_repaired || (data.kondisi_perbaikan === 'Baik');
        form.querySelector(`input[name="kondisi_perbaikan"][value="Tidak Baik"]`).checked = (data.kondisi_perbaikan === 'Tidak Baik');
        form.querySelector('input[name="tgl_perbaikan"]').value = data.tgl_perbaikan;
        form.querySelector('textarea[name="keterangan_perbaikan"]').value = data.keterangan_perbaikan || '';
        
        // Existing repair photo
        const repairPhotoContainer = document.getElementById('modalExistingRepairPhotoContainer');
        const repairPhotoImg = document.getElementById('modalExistingRepairPhoto');
        if (data.foto_perbaikan) {
            repairPhotoContainer.classList.remove('hidden');
            repairPhotoImg.src = data.foto_perbaikan;
        } else {
            repairPhotoContainer.classList.add('hidden');
            repairPhotoImg.src = '';
        }
        
        // Open modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        lucide.createIcons();
    }

    function closeRepairModal() {
        const modal = document.getElementById('repairModal');
        const content = modal.querySelector('div');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
