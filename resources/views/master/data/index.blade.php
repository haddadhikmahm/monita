@extends('layouts.app')

@section('title', 'List Data Peralatan - Monita HUD')
@section('header', 'Surveillance Artifact Inventory')

@section('content')
<div class="card-instrument fade-up">
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="package" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Inventaris Peralatan</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Technical Asset Surveillance Registry</p>
            </div>
        </div>
        <a href="{{ route('master-data.create') }}" class="btn-hud btn-hud-primary">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Tambah Artifact Baru</span>
        </a>
    </div>

    <div class="p-8 overflow-x-auto">
        <table id="artifactTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="10%">ASSET_ID [HEX]</th>
                    <th>Nama Peralatan / Arsitektur</th>
                    <th>Kategori Klasifikasi</th>
                    <th>Deployment Site</th>
                    <th width="15%">Aksi Protokol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $d)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="font-mono text-aviation-900 text-xs">#{{ str_pad($d->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="font-bold text-slate-800 tracking-wide">{{ $d->nama }}</td>
                    <td>
                        <span class="px-2 py-1 rounded bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase tracking-wider border border-amber-500/20">
                            {{ $d->kategori->nama }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3 h-3 text-slate-500"></i>
                            <span class="text-sm">{{ $d->lokasi->nama }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('master-data.edit', $d->id) }}" class="p-2 rounded-xl bg-aviation-accent/10 text-aviation-accent border border-aviation-accent/20 hover:bg-aviation-accent hover:text-white transition-all shadow-lg hover:shadow-aviation-accent/20" title="Edit Data">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('master-data.destroy', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all shadow-lg hover:shadow-rose-500/20" title="Hapus Data">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
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
        $('#artifactTable').DataTable({
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Artifact Inventory...",
                "lengthMenu": "Display _MENU_ logs per page",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
