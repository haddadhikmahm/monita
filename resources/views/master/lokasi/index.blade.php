@extends('layouts.app')

@section('title', 'List Lokasi - Monita HUD')
@section('header', 'Lokasi Inspeksi Terminal')

@section('content')
<div class="card-instrument fade-up">
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="map-pin" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Database Lokasi</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Operational Deployment Sites</p>
            </div>
        </div>
        <a href="{{ route('lokasi.create') }}" class="btn-hud btn-hud-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Lokasi Baru</span>
        </a>
    </div>

    <div class="p-8 overflow-x-auto">
        <table id="lokasiTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="10%">ID [HEX]</th>
                    <th>Nama Lokasi Surveillance</th>
                    <th width="20%">Aksi Protokol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lokasi as $l)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="font-mono text-aviation-900 text-xs">#{{ str_pad($l->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="font-bold text-slate-800 tracking-wide">{{ $l->nama }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('lokasi.edit', $l->id) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-500/10 text-amber-500 border border-amber-500/20 hover:bg-amber-500 hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest">
                                <i data-lucide="edit-3" class="w-3 h-3"></i> Edit
                            </a>
                            <form action="{{ route('lokasi.destroy', $l->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
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
        $('#lokasiTable').DataTable({
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Terminal Data...",
                "lengthMenu": "Display _MENU_ records",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
