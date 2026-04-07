@extends('layouts.app')

@section('title', 'Maintenance Log - Monita HUD')
@section('header', 'Maintenance surveillance Terminal')

@section('content')
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
                <a href="{{ route('maintenance.index') }}" class="btn-hud btn-hud-outline !py-2 !h-10">
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
            <div class="form-hud-group mb-0 md:col-span-2">
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
                    <th width="25%">Keterangan Kerusakan</th>
                    <th>Visual Documentation</th>
                    <th>Reported At</th>
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
                        <p class="text-xs font-semibold text-rose-600 bg-rose-50 p-3 rounded-xl border border-rose-100">
                            {{ $item->keterangan ?? 'No specific description provided.' }}
                        </p>
                    </td>
                    <td>
                        @if($item->foto)
                            <a href="{{ asset('images/kondisi/' . $item->foto) }}" target="_blank" class="block w-20 h-12 rounded-xl overflow-hidden border border-slate-200 group">
                                <img src="{{ asset('images/kondisi/' . $item->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="Documentation">
                            </a>
                        @else
                            <div class="w-20 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[8px] font-black uppercase text-slate-300">
                                No Foto
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800">{{ $item->inspeksi->tanggal->format('d/m/Y') }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">
                                {{ $item->created_at->format('H:i') }} hrs
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
</script>
@endsection
