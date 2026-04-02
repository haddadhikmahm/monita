<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MONITA.HUD - Angkasa Pura Official</title>
    <!-- Use Inter and Outfit Fonts from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --ap-blue: #0054A6;
            --ap-green: #79B933;
            --slate-white: #F8FAFC;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--slate-white);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(0, 84, 166, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(121, 185, 51, 0.05) 0%, transparent 50%);
            overflow: hidden;
        }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        .glass-login {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 40px 100px -20px rgba(0, 84, 166, 0.15);
        }

        .btn-ap-primary {
            background: linear-gradient(135deg, #0054A6 0%, #003D7A 100%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-ap-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(0, 84, 166, 0.4);
        }

        .input-ap {
            transition: all 0.3s ease;
        }
        .input-ap:focus {
            border-color: #0054A6;
            box-shadow: 0 0 0 4px rgba(0, 84, 166, 0.1);
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float { animation: float 8s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <!-- Animated Decoration -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#0054A6]/5 rounded-full blur-[120px] animate-pulse"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#79B933]/5 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative w-full max-w-[480px] z-10">
        <!-- Logo Area -->
        <div class="flex justify-center mb-10 space-x-4">
            <div class="bg-white p-3 rounded-2xl shadow-xl shadow-blue-900/5 border border-slate-100 flex items-center gap-3 pr-6">
                <div class="w-12 h-12 bg-[#0054A6] rounded-xl flex items-center justify-center transform rotate-3">
                    <i data-lucide="plane-takeoff" class="text-white w-7 h-7"></i>
                </div>
                <div>
                   <h2 class="font-outfit font-black text-[#0054A6] text-xl tracking-tighter leading-tight">MONITA<span class="text-slate-300">.HUD</span></h2>
                   <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Operational Excellence</p>
                </div>
            </div>
        </div>

        <!-- Login Card -->
        <div class="glass-login rounded-[40px] p-10 md:p-12">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-slate-800 mb-2 leading-tight">Access Control</h1>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-widest">Identify yourself to proceed</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Secure Access Key</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none group-focus-within:text-[#0054A6] transition-colors text-slate-300">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" 
                               class="input-ap block w-full pl-14 pr-6 py-5 bg-white/50 border border-slate-100 rounded-3xl text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none" 
                               placeholder="Authorized Username" required autofocus>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Encrypted Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none group-focus-within:text-[#0054A6] transition-colors text-slate-300">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" 
                               class="input-ap block w-full pl-14 pr-6 py-5 bg-white/50 border border-slate-100 rounded-3xl text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none" 
                               placeholder="Security Protocol Code" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-ap-primary w-full py-5 rounded-3xl text-white font-black text-sm uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                        Verify & Authorize
                    </button>
                </div>

                @if ($errors->has('login'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-center gap-3 animate-bounce">
                    <i data-lucide="alert-octagon" class="text-rose-500 w-5 h-5"></i>
                    <p class="text-xs font-bold text-rose-600 uppercase tracking-wide">{{ $errors->first('login') }}</p>
                </div>
                @endif
            </form>
        </div>

        <!-- Footer Info -->
        <div class="mt-10 flex items-center justify-center gap-6 opacity-30">
            <span class="h-px w-10 bg-slate-400"></span>
            <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.4em]">Official Monita Surveillance Terminal</p>
            <span class="h-px w-10 bg-slate-400"></span>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
