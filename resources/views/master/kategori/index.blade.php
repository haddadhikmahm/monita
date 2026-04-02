@extends('layouts.app')

@section('title', 'List Kategori - Monita HUD')
@section('header', 'Kategori Data Surveillance')

@section('content')
<div class="card-instrument fade-up">
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                <i data-lucide="layers" class="w-6 h-6 text-amber-500"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Klasifikasi Data</h3>
                <p class="text-[9px] font-bold text-amber-500 uppercase tracking-[0.3em]">Technical Artifact Categorization</p>
            </div>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn-hud btn-hud-primary bg-amber-500 hover:bg-amber-600 shadow-amber-500/20">
            <i data-lucide="plus-square" class="w-4 h-4"></i>
            <span>Tambah Kategori Baru</span>
        </a>
    </div>

    <div class="p-8 overflow-x-auto">
        <table id="kategoriTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="10%">ID [HEX]</th>
                    <th>Nama Klasifikasi Kategori</th>
                    <th width="20%">Aksi Protokol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori as $k)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="font-mono text-amber-600 text-xs">#{{ str_pad($k->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="font-bold text-slate-800 tracking-wide">{{ $k->nama }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('kategori.edit', $k->id) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-500 border border-blue-500/20 hover:bg-blue-500 hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest">
                                <i data-lucide="edit-2" class="w-3 h-3"></i> Sync
                            </a>
                            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest">
                                    <i data-lucide="trash" class="w-3 h-3"></i> Purge
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
        $('#kategoriTable').DataTable({
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Filter Classification...",
                "lengthMenu": "Show _MENU_ entries",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
