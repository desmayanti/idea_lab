<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEA LAB — Test Ideas. Analyze Data. Build Better.</title>

    <!-- Favicon & App Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Script Anti-Kedip: Cek Tema Tersimpan Sebelum Halaman Dirender -->
    <script>
        if (localStorage.getItem('idealab_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Tailwind CSS dengan Dukungan Dark Mode Class -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        nuvem: '#F4F5F7',     // Dominan (70%) - Cloud Off-White
                        azul: '#001B5E',      // Kontras Utama (15%) - Deep Royal Navy
                        horizonte: '#7189C6', // Sekunder (10%) - Periwinkle Blue
                        sol: '#FDB800',       // Aksen Sorotan (5%) - Sol de Minas Gold
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Data Visualization, 3D WebGL, Animation & Tilt Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <style>
        /* LIGHT MODE (Dominan Putih Nuvem #F4F5F7) */
        body {
            background-color: #F4F5F7;
            color: #001B5E;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background-color 0.35s ease, color 0.35s ease;
            background-image: 
                radial-gradient(circle at 12% 12%, rgba(113, 137, 198, 0.16) 0%, transparent 45%),
                radial-gradient(circle at 88% 22%, rgba(253, 184, 0, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 50% 85%, rgba(113, 137, 198, 0.10) 0%, transparent 50%);
        }
        /* DARK MODE (Dominan Azul Brant #001B5E) */
        html.dark body {
            background-color: #001B5E;
            color: #F4F5F7;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(113, 137, 198, 0.22) 0%, transparent 45%),
                radial-gradient(circle at 80% 15%, rgba(253, 184, 0, 0.12) 0%, transparent 40%);
        }

        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Kartu Glassmorphism Adaptif Light & Dark */
        .white-glass, .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(113, 137, 198, 0.28);
            box-shadow: 0 18px 45px rgba(0, 27, 94, 0.06);
            transition: all 0.3s ease;
            color: #001B5E;
        }
        html.dark .white-glass, html.dark .glass-panel {
            background: rgba(113, 137, 198, 0.14);
            border: 1px solid rgba(113, 137, 198, 0.35);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            color: #F4F5F7;
        }

        .white-glass-gold {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 2px solid rgba(253, 184, 0, 0.85);
            box-shadow: 0 20px 50px rgba(253, 184, 0, 0.15);
            transition: all 0.3s ease;
        }
        html.dark .white-glass-gold {
            background: rgba(253, 184, 0, 0.12);
            border: 2px solid #FDB800;
            box-shadow: 0 20px 50px rgba(253, 184, 0, 0.25);
            color: #F4F5F7;
        }

        .pill-shadow {
            box-shadow: 0 12px 32px rgba(0, 27, 94, 0.08);
        }
        .glow-sol {
            box-shadow: 0 10px 30px rgba(253, 184, 0, 0.35);
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #FFFFFF !important; color: #001B5E !important; }
            .white-glass, .glass-panel { background: #FFFFFF !important; box-shadow: none !important; border: 1px solid #7189C6 !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col selection:bg-sol selection:text-azul">

    <!-- Clean Architectural Top Navbar (Full Width Sticky) -->
    <header class="no-print w-full sticky top-0 z-50 bg-white/85 dark:bg-[#001B5E]/90 backdrop-blur-xl border-b border-slate-200/80 dark:border-[#7189C6]/25">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Left: Square-rounded Logo + Wordmark -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="IDEA LAB Logo" class="w-9 h-9 rounded-lg object-contain shadow-sm group-hover:scale-105 transition-transform duration-200">
                <div>
                    <span class="font-display font-extrabold text-lg tracking-tight text-azul dark:text-nuvem">IDEA<span class="text-horizonte">LAB.</span></span>
                </div>
            </a>

            <!-- Center: Clean Navigation Links -->
            <nav class="flex items-center gap-1 md:gap-2 text-xs md:text-sm font-bold">
                <a href="{{ route('landing') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('landing') ? 'bg-[#001B5E] text-white dark:bg-[#FDB800] dark:text-[#001B5E] shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-azul dark:hover:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    Studio 3D
                </a>
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-[#001B5E] text-white dark:bg-[#FDB800] dark:text-[#001B5E] shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-azul dark:hover:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    Matriks Kuadran
                </a>
                <a href="{{ route('survey.create') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('survey.*') ? 'bg-[#001B5E] text-white dark:bg-[#FDB800] dark:text-[#001B5E] shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-azul dark:hover:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    Isi Survei
                </a>
                <a href="{{ route('ideas.index') }}" class="hidden sm:inline-block px-3 py-1.5 rounded-lg transition {{ request()->routeIs('ideas.*') ? 'bg-[#001B5E] text-white dark:bg-[#FDB800] dark:text-[#001B5E] shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-azul dark:hover:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    Kelola Ide
                </a>
                <a href="{{ route('respondents.index') }}" class="hidden md:inline-block px-3 py-1.5 rounded-lg transition {{ request()->routeIs('respondents.*') ? 'bg-[#001B5E] text-white dark:bg-[#FDB800] dark:text-[#001B5E] shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-azul dark:hover:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    Responden
                </a>
            </nav>

            <!-- Right: Compact Download PDF Button & Theme Toggle -->
            <div class="flex items-center gap-2">
                <a href="{{ route('report.pdf') }}" class="px-4 py-2 rounded-lg bg-sol text-azul text-xs md:text-sm font-extrabold hover:brightness-105 transition shadow-sm flex items-center gap-1.5">
                    <span>📄</span> <span class="hidden sm:inline">Download</span> PDF
                </a>
                <button id="themeToggleBtn" type="button" title="Ganti Light / Dark Mode"
                    class="w-9 h-9 rounded-lg border border-slate-200 dark:border-[#7189C6]/30 bg-slate-100/90 dark:bg-slate-800/90 flex items-center justify-center text-azul dark:text-sol hover:bg-slate-200 dark:hover:bg-slate-700 transition shadow-sm">
                    <span id="themeIcon">🌙</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success'))
    <div class="no-print max-w-6xl mx-auto px-6 pt-6 w-full">
        <div class="p-4 rounded-2xl bg-sol/20 border-2 border-sol text-azul dark:text-sol font-bold flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-azul dark:text-sol font-black hover:opacity-75">✕</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="no-print max-w-6xl mx-auto px-6 pt-6 w-full">
        <div class="p-4 rounded-2xl bg-red-500/10 border-2 border-red-500 text-red-700 dark:text-red-300 font-bold flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700 dark:text-red-300 font-black hover:opacity-75">✕</button>
        </div>
    </div>
    @endif

    <!-- Konten Utama -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Clean Editorial Footer -->
    <footer class="no-print border-t border-horizonte/20 bg-white/70 dark:bg-azul/50 py-6 mt-20 text-xs text-azul/70 dark:text-horizonte">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <div>
                <p class="font-extrabold text-azul dark:text-nuvem text-sm">IDEA LAB — Test Ideas. Analyze Data. Build Better.</p>
                <p class="text-azul/60 dark:text-horizonte/80 mt-0.5">Laboratorium Digital Validasi Inovasi E-Commerce KYOTO STORE</p>
            </div>
            <p class="text-azul/50 dark:text-horizonte/60 text-[11px]">&copy; {{ date('Y') }} IDEA LAB. All rights reserved.</p>
        </div>
    </footer>

    <!-- Script Pengatur Light / Dark Mode Toggle -->
    <script>
        const htmlEl = document.documentElement;
        const toggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');

        function updateIcon() {
            if (themeIcon) {
                themeIcon.textContent = htmlEl.classList.contains('dark') ? '☀️' : '🌙';
            }
        }
        updateIcon();

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                htmlEl.classList.toggle('dark');
                const isDark = htmlEl.classList.contains('dark');
                localStorage.setItem('idealab_theme', isDark ? 'dark' : 'light');
                updateIcon();
            });
        }
    </script>
</body>
</html>
