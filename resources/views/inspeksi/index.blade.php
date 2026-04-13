@extends('layouts.app')

@section('title', 'List Inspeksi - Monita HUD')
@section('header', 'Riwayat Protokol Inspeksi')

@section('content')
<div class="card-instrument fade-up">
    <!-- HUD Header with Strategic Summary -->
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="clipboard-list" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Archive Log Inspeksi</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Historical Surveillance Records</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="openScanner()" class="btn-hud bg-aviation-success text-white shadow-2xl hover:scale-105 border-none px-6">
                <i data-lucide="scan-line" class="w-4 h-4"></i> Scan QR Alat
            </button>
            <a href="{{ route('inspeksi.create') }}" class="btn-hud btn-hud-primary">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Entry Inspeksi Baru</span>
            </a>
        </div>
    </div>

    @include('layouts.partials.scanner')

    <!-- Advanced Logic Filter Console -->
    <div class="p-8 bg-slate-50/50 border-b border-slate-100">
        <form action="{{ route('inspeksi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
                <a href="{{ route('inspeksi.index') }}" class="btn-hud btn-hud-outline !py-2 !h-10">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <!-- Second Row Filters -->
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
        <table id="inspeksiHudTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="15%">REF_ID [HEX]</th>
                    <th>Timestamp Data</th>
                    <th>Node Lokasi</th>
                    <th>Operator Unit I</th>
                    <th>Kondisi Atmosfer</th>
                    <th width="15%">Aksi Protokol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inspeksis as $i)
                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100">
                    <td class="font-mono text-aviation-900 text-xs">#{{ str_pad($i->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="font-bold text-slate-800 tracking-wide text-xs">
                        {{ $i->tanggal->format('d/m/Y') }} <span class="text-slate-400 font-normal ml-2">[{{ $i->hari }}]</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-aviation-900"></i>
                            <span class="text-sm font-semibold">{{ $i->lokasi->nama }}</span>
                        </div>
                    </td>
                    <td class="font-bold text-slate-600 text-sm">{{ $i->petugas1->name }}</td>
                    <td>
                        <span class="px-2 py-1 rounded bg-sky-500/10 text-sky-600 text-[10px] font-black uppercase tracking-widest border border-sky-500/20">
                            {{ $i->cuaca }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('inspeksi.show', $i->id) }}" class="p-2 rounded-xl bg-aviation-900/10 text-aviation-900 border border-aviation-900/20 hover:bg-aviation-900 hover:text-white transition-all shadow-lg hover:shadow-aviation-900/20" title="Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('inspeksi.pdf', $i->id) }}" class="p-2 rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all shadow-lg hover:shadow-rose-500/20" target="_blank" title="Download PDF">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </a>
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
        $('#inspeksiHudTable').DataTable({
            "order": [[1, "desc"]],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Log Archives...",
                "lengthMenu": "Display _MENU_ Records",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
