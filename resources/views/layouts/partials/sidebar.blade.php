<!-- Sidebar Header: Brand Identity -->
<div class="h-24 px-8 flex items-center gap-4 bg-brand-gradient shadow-2xl relative overflow-hidden group">
    <div class="radar-ping"></div> <!-- Subtle Brand Ping -->
    <div :class="!sidebarOpen ? 'w-10 h-10 rounded-xl -ml-1' : 'w-12 h-12 rounded-2xl'"
         class="bg-white flex items-center justify-center shrink-0 shadow-lg relative z-10 transition-all duration-500">
        <i data-lucide="plane-takeoff" 
           :class="!sidebarOpen ? 'w-5 h-5' : 'w-7 h-7'"
           class="text-aviation-900 group-hover:rotate-12 transition-all duration-500"></i>
    </div>
    <div class="flex flex-col relative z-10" x-show="sidebarOpen">
        <h1 class="text-white font-black text-xs tracking-[.4em] uppercase leading-none">Angkasa Pura</h1>
        <p class="text-aviation-success font-black text-[10px] uppercase tracking-[.2em] mt-1.5 opacity-80">AIRPORTS</p>
    </div>
</div>

<!-- Main Navigation Module -->
<div class="flex-1 px-4 py-8 space-y-8 overflow-y-auto custom-scrollbar">
    
    <!-- Strategic Overview -->
    <div class="space-y-2">
        <p class="px-6 text-[9px] font-black text-slate-400 uppercase tracking-[.4em] mb-4" x-show="sidebarOpen">Strategic Operations</p>
        <a href="{{ route('dashboard') }}" class="nav-instrument {{ Request::is('dashboard') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Pusat Kendali</span>
        </a>
    </div>

    <!-- Surveillance Administration -->
    <div class="space-y-2">
        <p class="px-6 text-[9px] font-black text-slate-400 uppercase tracking-[.4em] mb-4" x-show="sidebarOpen">Master Data Terminal</p>
        
        <a href="{{ route('master-data.index') }}" class="nav-instrument {{ Request::is('master-data*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Inventaris Alat</span>
        </a>

        @if(Auth::user()->role == 'admin')
        <a href="{{ route('lokasi.index') }}" class="nav-instrument {{ Request::is('lokasi*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="map-pin" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Node Lokasi</span>
        </a>

        <a href="{{ route('kategori.index') }}" class="nav-instrument {{ Request::is('kategori*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="layers" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Klasifikasi</span>
        </a>
        @endif
    </div>

    <!-- Active Missions / Reports -->
    <div class="space-y-2">
        <p class="px-6 text-[9px] font-black text-slate-400 uppercase tracking-[.4em] mb-4" x-show="sidebarOpen"">Operational Logs</p>
        <a href="{{ route('inspeksi.index') }}" class="nav-instrument {{ Request::is('inspeksi*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Laporan Inspeksi</span>
        </a>

        <a href="{{ route('maintenance.index') }}" class="nav-instrument {{ Request::is('maintenance*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="wrench" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Maintenance Log</span>
        </a>
    </div>

    <!-- Administrative Protocol -->
    @if(Auth::user()->role == 'admin')
    <div class="space-y-2">
        <p class="px-6 text-[9px] font-black text-slate-400 uppercase tracking-[.4em] mb-4" x-show="sidebarOpen">User Clearance</p>
        <a href="{{ route('user.index') }}" class="nav-instrument {{ Request::is('user*') ? 'nav-instrument-active' : '' }} group">
            <i data-lucide="shield-check" class="w-5 h-5"></i>
            <span x-show="sidebarOpen" class="tracking-widest uppercase text-[10px] font-black">Manajemen Unit</span>
        </a>
    </div>
    @endif
</div>

<!-- Sidebar Footer: Operational Status -->
<div class="p-6 border-t border-slate-100" x-show="sidebarOpen">
    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-aviation-success animate-pulse shadow-[0_0_8px_#79B933]"></div>
            <span class="text-[9px] font-black text-aviation-900 uppercase tracking-widest">Network Connected</span>
        </div>
        <div class="mt-3 space-y-1">
            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Server Latency: <span class="text-aviation-900">0.08ms</span></p>
            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Security Protocol: <span class="text-aviation-success font-black">TLS 1.3</span></p>
        </div>
    </div>
</div>
