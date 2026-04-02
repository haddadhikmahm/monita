@extends('layouts.app')

@section('title', 'Kelola User - Monita HUD')
@section('header', 'Personnel Management: ' . ucfirst($role))

@section('content')
<div class="card-instrument fade-up">
    <!-- HUD Header with Role Switcher -->
    <div class="p-8 border-b border-slate-100 flex flex-col xl:flex-row items-center justify-between gap-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-aviation-900/10 flex items-center justify-center border border-aviation-900/20">
                <i data-lucide="shield-check" class="w-6 h-6 text-aviation-900"></i>
            </div>
            <div>
                <h3 class="font-black text-lg text-slate-800 tracking-widest uppercase">Database Personel</h3>
                <p class="text-[9px] font-bold text-aviation-900 uppercase tracking-[0.3em]">Authorized Unit Access Control</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="flex bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                <a href="{{ route('user.index', ['role' => 'petugas']) }}" 
                   class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all {{ $role == 'petugas' ? 'bg-aviation-900 text-white shadow-lg shadow-aviation-900/20' : 'text-slate-400 hover:text-aviation-900' }}">
                    Petugas
                </a>
                <a href="{{ route('user.index', ['role' => 'pimpinan']) }}" 
                   class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all {{ $role == 'pimpinan' ? 'bg-aviation-900 text-white shadow-lg shadow-aviation-900/20' : 'text-slate-400 hover:text-aviation-900' }}">
                    Pimpinan
                </a>
                <a href="{{ route('user.index', ['role' => 'admin']) }}" 
                   class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all {{ $role == 'admin' ? 'bg-aviation-900 text-white shadow-lg shadow-aviation-900/20' : 'text-slate-400 hover:text-aviation-900' }}">
                    Admin
                </a>
            </div>
            <a href="#" class="btn-hud btn-hud-primary bg-rose-600 hover:bg-rose-700 shadow-rose-600/20">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Enlist New Unit</span>
            </a>
        </div>
    </div>

    <!-- HUD Table Content -->
    <div class="p-8 overflow-x-auto">
        <table id="userHudTable" class="table-hud table-hud-bordered">
            <thead>
                <tr>
                    <th width="5%">ORD</th>
                    <th width="10%">Ident</th>
                    <th width="15%">Unit_ID [HEX]</th>
                    <th>Full Legal Name</th>
                    <th>System Identity</th>
                    <th>Security clearance</th>
                    <th width="10%">OP_CMD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100">
                    <td class="font-mono text-[10px] text-slate-400 text-center">{{ $loop->iteration }}</td>
                    <td>
                        <div class="relative w-10 h-10 rounded-xl overflow-hidden ring-2 ring-slate-100">
                            <img src="{{ $u->ft ? asset('images/user/' . $u->ft) : asset('images/user/user.png') }}" 
                                 class="w-full h-full object-cover" alt="">
                        </div>
                    </td>
                    <td class="font-mono text-aviation-900 text-xs">#{{ str_pad($u->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="font-bold text-slate-800 tracking-wide">{{ $u->name }}</td>
                    <td class="font-medium text-slate-500">{{ $u->username }}</td>
                    <td>
                        <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $u->role == 'admin' ? 'bg-rose-500/10 text-rose-500 border-rose-500/20' : ($u->role == 'petugas' ? 'bg-aviation-accent/10 text-aviation-accent border-aviation-accent/20' : 'bg-amber-500/10 text-amber-500 border-amber-500/20') }}">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="#" class="p-2 rounded-xl bg-aviation-accent/10 text-aviation-accent border border-aviation-accent/20 hover:bg-aviation-accent hover:text-white transition-all shadow-lg hover:shadow-aviation-accent/20" title="Edit">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </a>
                            <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all shadow-lg hover:shadow-rose-500/20" title="Purge">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
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
        $('#userHudTable').DataTable({
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search Unit Status...",
                "lengthMenu": "Displaying _MENU_ Records",
            },
            "drawCallback": function() {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
