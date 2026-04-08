<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | MONITA AP</title>

    <!-- Google Fonts: Instrument Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


    <style>
        [x-cloak] { display: none !important; }
        .fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-sans selection:bg-aviation-900 selection:text-white" x-data="{ sidebarOpen: true, loading: true }" x-init="setTimeout(() => loading = false, 800)">
    
    <!-- Official Loader -->
    <div x-show="loading" class="fixed inset-0 z-[100] bg-white flex flex-col items-center justify-center transition-all duration-700" x-transition:leave="opacity-0 scale-110">
        <div class="relative">
            <div class="w-24 h-24 rounded-full border-4 border-slate-100 border-t-aviation-900 animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center font-black text-aviation-900 text-xs tracking-[.3em] uppercase">AP</div>
        </div>
        <p class="mt-8 font-black text-slate-400 text-[10px] uppercase tracking-[.5em] animate-pulse">Initializing Terminal</p>
    </div>

    <!-- Sidebar Toggle (Mobile) -->
    <div class="lg:hidden fixed bottom-6 right-6 z-[60]">
        <button @click="sidebarOpen = !sidebarOpen" class="w-14 h-14 rounded-2xl bg-aviation-900 text-white shadow-2xl flex items-center justify-center border border-white/20 active:scale-90 transition-all group">
            <i x-show="!sidebarOpen" data-lucide="menu" class="w-6 h-6 text-aviation-success transition-transform group-hover:scale-110"></i>
            <i x-show="sidebarOpen" data-lucide="x" class="w-6 h-6 text-aviation-success transition-transform group-hover:scale-110"></i>
        </button>
    </div>

    <!-- Main Surveillance Interface -->
    <div class="flex min-h-screen radar-grid relative">
        <!-- Animated Background Ping -->
        <div class="radar-ping"></div>

        <!-- Official Sidebar Container -->
        <aside 
            :class="{
                'w-64 lg:w-80 translate-x-0': sidebarOpen,
                'w-24 translate-x-0': !sidebarOpen && window.innerWidth >= 1024,
                'w-0 -translate-x-full': !sidebarOpen && window.innerWidth < 1024,
                'fixed inset-y-0 left-0 z-50 shadow-2xl': window.innerWidth < 1024
            }"
            class="bg-white border-r border-slate-200 transition-all duration-500 ease-in-out flex flex-col z-40 relative group shrink-0 lg:static">
            @include('layouts.partials.sidebar')
            
            <!-- Sidebar Toggle (Desktop) -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="absolute -right-4 top-10 w-8 h-8 rounded-full bg-white border border-slate-200 shadow-xl flex items-center justify-center transition-all duration-300 z-50 group hover:scale-110">
                <!-- Chevron Left (Sidebar Open) -->
                <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#79B933" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                <!-- Chevron Right (Sidebar Closed) -->
                <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#79B933" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </button>
        </aside>

        <!-- Command Area -->
        <main class="flex-1 flex flex-col min-w-0 transition-all duration-500 relative bg-[#F1F5F9]/50">
            
            <!-- Global Terminal Header -->
            <header class="h-24 glass-hud sticky top-0 z-30 px-6 md:px-12 flex items-center justify-between border-b border-slate-200/60">
                <div class="flex items-center gap-4 md:gap-8 ml-12 md:ml-24">
                    <!-- Brand Mobile -->
                    <!-- Title HUD -->
                    <div class="flex flex-col shrink-0">
                        <h2 class="text-[9px] md:text-xs font-black text-aviation-900 uppercase tracking-[.4em] whitespace-nowrap">@yield('header', 'MONITORING CENTER')</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-aviation-success shadow-[0_0_8px_#79B933]"></span>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Status: Operational</span>
                        </div>
                    </div>
                </div>

                <!-- Technical HUD Stats -->
                <div class="flex items-center gap-4 md:gap-12">
                    <!-- Unit Time -->
                    <div class="hidden sm:flex flex-col items-end shrink-0">
                        <span id="unit-clock" class="text-lg md:text-xl font-bold text-aviation-900 font-mono tracking-tighter">00:00:00</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ date('d M Y') }}</span>
                    </div>

                    <!-- Action HUD -->
                    <div class="flex items-center gap-4">
                        <!-- User Identity HUD -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" 
                                    class="flex items-center gap-2 md:gap-3 p-1 md:p-1.5 h-12 md:h-14 hover:bg-slate-100 rounded-2xl transition-all border border-slate-200 hover:border-aviation-900/40 group">
                                <img src="{{ asset('images/' . (Auth::user()->ft ?: 'user.png')) }}" 
                                     class="w-8 h-8 md:w-10 md:h-10 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-aviation-900/10" alt="">
                                <div class="hidden lg:flex flex-col text-left">
                                    <p class="text-[10px] font-black text-aviation-900 leading-none whitespace-nowrap">{{ Auth::user()->name }}</p>
                                    <p class="text-[8px] text-aviation-success font-black uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                                </div>
                                <i data-lucide="chevron-down" 
                                   :class="open ? 'rotate-180' : ''"
                                   class="w-3 md:w-4 h-3 md:h-4 text-slate-400 transition-transform duration-300"></i>
                            </button>
                            
                            <!-- Dropdown HUD -->
                            <div x-show="open" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="absolute right-0 mt-4 w-[280px] md:w-[360px] bg-white border border-slate-200 shadow-2xl p-4 rounded-2xl z-50 whitespace-nowrap">
                                <div class="pb-3 mb-2 border-b border-slate-100">
                                    <p class="text-[9px] font-black text-aviation-900 uppercase tracking-widest mb-1">Authenticating User</p>
                                    <p class="text-sm font-black text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-mono">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="space-y-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-aviation-900 transition-all">
                                        <i data-lucide="user" class="w-4 h-4"></i> Profile Details
                                    </a>
                                </div>
                                <div class="my-2 border-t border-slate-100"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-aviation-danger hover:bg-rose-50 rounded-xl transition-all border border-transparent hover:border-rose-100 text-left">
                                        <i data-lucide="power" class="w-4 h-4"></i> Terminate Session
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Deployment Area -->
            <div class="px-4 md:px-8 pt-10 pb-6 md:pt-14 md:pb-8 flex-1 relative overflow-hidden">
                <div class="max-w-screen-2xl mx-auto">
                    @if(session('success'))
                        <div class="fade-up mb-8 flex items-center gap-6 p-6 bg-white border border-aviation-success/20 text-aviation-success rounded-3xl shadow-xl shadow-aviation-success/5 animate-pulse-glow" x-data="{ show: true }" x-show="show">
                            <div class="w-14 h-14 rounded-2xl bg-aviation-success/10 flex items-center justify-center shrink-0 border border-aviation-success/30 shadow-lg shadow-aviation-success/10">
                                <i data-lucide="shield-check" class="w-7 h-7"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-black uppercase tracking-widest text-xs">System Affirmative</h4>
                                <p class="text-slate-500 font-bold mt-1 text-sm">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-slate-400 hover:text-aviation-success transition-colors">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    @endif

                    <!-- CORE CONTENT DEPLOY -->
                    <div class="fade-up delay-200">
                        @yield('content')
                    </div>
                </div>
            </div>

            <!-- Global Footer Status -->
            <footer class="h-14 px-10 border-t border-slate-200/60 flex items-center justify-between text-[10px] font-black uppercase tracking-[.3em] text-slate-400 bg-white/50 backdrop-blur">
                <div class="flex items-center gap-6">
                    <span class="text-aviation-900">&copy; {{ date('Y') }} MONITA.AP</span>
                    <span class="w-[1px] h-4 bg-slate-200"></span>
                    <span>Sepinggan Airfield Surveillance Terminal</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-aviation-success">System Nominal</span>
                    <span class="text-slate-300">V4.0.0-PRO</span>
                </div>
            </footer>
        </main>
    </div>

    @yield('js')
    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // High Precision Terminal Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { 
                hour12: false, 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const clockEl = document.getElementById('unit-clock');
            if(clockEl) clockEl.textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
