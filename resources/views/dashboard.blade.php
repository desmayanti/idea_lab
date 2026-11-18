@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    <!-- 1. Unified 5-Column Architectural KPI Metric Ribbon (Bab 4.2) -->
    <div class="bg-white dark:bg-[#0B1736] border border-slate-200/90 dark:border-[#7189C6]/25 rounded-2xl shadow-sm overflow-hidden">
        <div class="grid grid-cols-2 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-slate-200/80 dark:divide-[#7189C6]/20">
            <!-- Col 1: Total Ide Solusi -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Total Ide Solusi</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-extrabold text-azul dark:text-nuvem">{{ count($ideas) }}</p>
                </div>
                <span class="text-[11px] text-slate-400 dark:text-slate-400 font-medium">10 Solusi E-Commerce</span>
            </div>

            <!-- Col 2: Total Responden -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Total Responden</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-extrabold text-[#FDB800]">{{ $totalRespondents }}</p>
                </div>
                <span class="text-[11px] text-slate-400 dark:text-slate-400 font-medium">Responden Terverifikasi</span>
            </div>

            <!-- Col 3: Rata-rata Feasibility -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Rata-rata Feasibility</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-extrabold text-azul dark:text-nuvem">
                        {{ $globalFeasibility }} <span class="text-xs text-slate-400 dark:text-[#7189C6] font-semibold">/ 5.0</span>
                    </p>
                </div>
                <span class="text-[11px] text-slate-400 dark:text-slate-400 font-medium">Kelayakan Teknis</span>
            </div>

            <!-- Col 4: Rata-rata Impact -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Rata-rata Impact</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-extrabold text-azul dark:text-nuvem">
                        {{ $globalImpact }} <span class="text-xs text-slate-400 dark:text-[#7189C6] font-semibold">/ 5.0</span>
                    </p>
                </div>
                <span class="text-[11px] text-slate-400 dark:text-slate-400 font-medium">Dampak Bisnis &amp; User</span>
            </div>

            <!-- Col 5: Highlighted Winner Cell (Solid Navy) -->
            <div class="col-span-2 lg:col-span-1 p-5 bg-[#001B5E] text-white flex flex-col justify-between">
                <span class="text-[11px] text-[#FDB800] font-black uppercase tracking-wider">Ide Skor Tertinggi</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-black text-[#FDB800] leading-none">
                        {{ $topIdea['total_score'] ?? 0 }} <span class="text-xs text-white/70 font-bold">/ 10.0</span>
                    </p>
                    <p class="text-xs font-bold truncate mt-1.5 text-white/95" title="{{ $topIdea['code'] ?? '-' }} — {{ $topIdea['title'] ?? '' }}">
                        {{ $topIdea['code'] ?? '-' }} — {{ $topIdea['title'] ?? '' }}
                    </p>
                </div>
                <span class="text-[11px] text-[#7189C6] font-medium">Peringkat #1 Terpilih</span>
            </div>
        </div>
    </div>

    <!-- 2. Integrated 4-Quadrant Status Strip -->
    <div class="bg-slate-50/90 dark:bg-[#071126] border border-slate-200/80 dark:border-[#7189C6]/20 rounded-xl grid grid-cols-2 lg:grid-cols-4 divide-x divide-slate-200/70 dark:divide-[#7189C6]/20 overflow-hidden shadow-sm">
        <!-- Segment 1: Prioritas Utama (#FDB800) -->
        <div class="p-4 border-t-4 border-t-[#FDB800] bg-white/60 dark:bg-transparent flex flex-col justify-between gap-2">
            <div class="flex items-center justify-between gap-1">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Prioritas Utama</span>
                <code class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-100/80 dark:bg-amber-950/50 text-amber-900 dark:text-amber-300">F≥4, I≥4</code>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <strong class="text-2xl font-display font-black text-azul dark:text-[#FDB800]">
                    {{ $quadrantCounts['Prioritas Utama'] ?? 0 }} <span class="text-xs font-semibold text-slate-500">Ide</span>
                </strong>
                <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">Implementasi Cepat</span>
            </div>
        </div>

        <!-- Segment 2: Potensi (#7189C6) -->
        <div class="p-4 border-t-4 border-t-[#7189C6] bg-white/60 dark:bg-transparent flex flex-col justify-between gap-2">
            <div class="flex items-center justify-between gap-1">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Potensi</span>
                <code class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-100/80 dark:bg-blue-950/50 text-blue-900 dark:text-blue-300">F&lt;4, I≥4</code>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <strong class="text-2xl font-display font-black text-[#7189C6]">
                    {{ $quadrantCounts['Potensi'] ?? 0 }} <span class="text-xs font-semibold text-slate-500">Ide</span>
                </strong>
                <span class="text-[10px] font-semibold text-blue-600 dark:text-blue-400">Riset &amp; Matangkan</span>
            </div>
        </div>

        <!-- Segment 3: Pertimbangkan (#001B5E / Sky in dark mode) -->
        <div class="p-4 border-t-4 border-t-[#001B5E] dark:border-t-sky-400 bg-white/60 dark:bg-transparent flex flex-col justify-between gap-2">
            <div class="flex items-center justify-between gap-1">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Pertimbangkan</span>
                <code class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-200/80 dark:bg-slate-800 text-slate-800 dark:text-slate-200">F≥4, I&lt;4</code>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <strong class="text-2xl font-display font-black text-azul dark:text-slate-100">
                    {{ $quadrantCounts['Pertimbangkan'] ?? 0 }} <span class="text-xs font-semibold text-slate-500">Ide</span>
                </strong>
                <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400">Tingkatkan Dampak</span>
            </div>
        </div>

        <!-- Segment 4: Tunda (#EF4444) -->
        <div class="p-4 border-t-4 border-t-[#EF4444] bg-white/60 dark:bg-transparent flex flex-col justify-between gap-2">
            <div class="flex items-center justify-between gap-1">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Tunda</span>
                <code class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-rose-100/80 dark:bg-rose-950/50 text-rose-900 dark:text-rose-300">F&lt;4, I&lt;4</code>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <strong class="text-2xl font-display font-black text-[#EF4444]">
                    {{ $quadrantCounts['Tunda'] ?? 0 }} <span class="text-xs font-semibold text-slate-500">Ide</span>
                </strong>
                <span class="text-[10px] font-semibold text-rose-600 dark:text-rose-400">Arsipkan Sementara</span>
            </div>
        </div>
    </div>

    <!-- Banner Rekomendasi Ide Terpilih (Pemenang Bab 4.9 & Tie-Breaker Logic) -->
    @if($topIdea)
    <div class="white-glass-gold p-8 rounded-4xl relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3 max-w-3xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3.5 py-1 rounded-full bg-sol text-azul font-black text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                        <span>★</span> REKOMENDASI IDE TERPILIH (PERINGKAT #1)
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-azul text-nuvem">
                        Kuadran: {{ $topIdea['quadrant'] }}
                    </span>
                    @if($isTie)
                    <span class="px-3 py-1 rounded-full bg-orange-500 text-white text-xs font-bold">
                        ⚠️ Status Seri (Tie Breaker Aktif)
                    </span>
                    @endif
                </div>

                <h2 class="font-display text-2xl md:text-4xl font-extrabold text-azul tracking-tight">
                    {{ $topIdea['code'] }}: {{ $topIdea['title'] }}
                </h2>

                <p class="text-azul/75 text-sm leading-relaxed">{{ $topIdea['description'] }}</p>

                <div class="pt-2 text-xs text-azul bg-nuvem/90 p-4 rounded-2xl border border-horizonte/20 space-y-1">
                    <strong class="text-azul block uppercase tracking-wider text-[11px]">Alasan Rekomendasi Sistem (Bab 4.9):</strong>
                    <p class="leading-relaxed text-azul/80">
                        Ide ini meraih <strong>Total Skor tertinggi {{ $topIdea['total_score'] }} / 10.0</strong> dari akumulasi {{ $topIdea['respondents_count'] }} responden.
                        Dengan skor <strong>Feasibility {{ $topIdea['avg_feasibility'] }}</strong> dan <strong>Impact {{ $topIdea['avg_impact'] }}</strong> (keduanya melampaui batas ambang kuadran 4.00), solusi ini terbukti sangat layak dikembangkan serta memberikan manfaat tertinggi bagi sasaran (<strong class="text-azul">{{ $topIdea['target_user'] }}</strong>).
                    </p>
                </div>
            </div>

            <!-- Score Badges Group -->
            <div class="flex gap-3 shrink-0 justify-around">
                <div class="p-4 rounded-2xl bg-white border border-horizonte/30 text-center min-w-27.5 shadow-sm">
                    <span class="text-[10px] text-horizonte uppercase font-bold block">Feasibility</span>
                    <strong class="text-2xl font-display font-extrabold text-azul mt-1 block">{{ $topIdea['avg_feasibility'] }}</strong>
                    <span class="text-[10px] text-azul/50 font-semibold">Skala 1 - 5</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-horizonte/30 text-center min-w-27.5 shadow-sm">
                    <span class="text-[10px] text-horizonte uppercase font-bold block">Impact</span>
                    <strong class="text-2xl font-display font-extrabold text-azul mt-1 block">{{ $topIdea['avg_impact'] }}</strong>
                    <span class="text-[10px] text-azul/50 font-semibold">Skala 1 - 5</span>
                </div>
                <div class="p-4 rounded-2xl bg-azul text-nuvem text-center min-w-27.5 shadow-md">
                    <span class="text-[10px] text-sol uppercase font-black block">Total Skor</span>
                    <strong class="text-2xl font-display font-black text-sol mt-1 block">{{ $topIdea['total_score'] }}</strong>
                    <span class="text-[10px] text-nuvem/70 font-semibold">Maks 10.0</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Grafik Matriks Kuadran 2D & Grafik Total Skor (Light Theme) -->
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- 1. Grafik Matriks Feasibility vs Impact (2D Scatter Quadrant) -->
        <div class="white-glass p-6 rounded-4xl border border-horizonte/25 flex flex-col justify-between">
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase text-horizonte tracking-wider">BAB 4.7 • GRAFIK MATRIKS 2D</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-sol/20 text-azul text-[10px] font-black">Threshold = 4.00</span>
                </div>
                <h3 class="text-xl font-display font-bold text-azul mt-1">Peta Matriks Feasibility vs Impact</h3>
                <p class="text-xs text-azul/65">Sebaran 10 ide berdasarkan koordinat rata-rata Feasibility (X) dan Impact (Y).</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-horizonte/20 shadow-inner">
                <canvas id="quadrantMatrixChart" height="280"></canvas>
            </div>
        </div>

        <!-- 2. Grafik Total Skor 10 Ide (Bar Chart) -->
        <div class="white-glass p-6 rounded-4xl border border-horizonte/25 flex flex-col justify-between">
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase text-horizonte tracking-wider">BAB 5.2 • GRAFIK TOTAL SKOR</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-azul/10 text-azul text-[10px] font-black">Maksimal 10.0</span>
                </div>
                <h3 class="text-xl font-display font-bold text-azul mt-1">Peringkat Total Skor 10 Ide</h3>
                <p class="text-xs text-azul/65">Diurutkan berdasarkan skor tertinggi: Feasibility + Impact.</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-horizonte/20 shadow-inner">
                <canvas id="totalScoreChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- RUANG VISUALISASI 3D • ULTIMATE SOLID STUDIO + PANEL INSPEKSI DETAIL KLIK -->
    <!-- ========================================================================= -->
<!-- RUANG VISUALISASI 3D • THREE.JS SOLID STUDIO (CLEAN STAGE + HOVER FLOAT)  -->
<!-- ========================================================================= -->
<section id="solidStudioSection" class="max-w-7xl mx-auto my-8 px-4 sm:px-6">

    <!-- HEADER JUDUL & SUBTITLE BERSIH (TANPA TOMBOL DI LUAR KOTAK) -->
    <div class="mb-4">
        <div class="flex items-center gap-2.5 flex-wrap mb-1.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"></path>
                </svg>
            </div>
            <h2 class="font-display text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Ruang Visualisasi 3D
            </h2>
            <span class="px-3 py-1 rounded-full bg-[#FEF3C7] border border-[#FDE68A] text-[#92400E] text-xs font-extrabold flex items-center gap-1">
                ✨ Three.js Solid Studio
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">
            Warna bola mengikuti 4 kategori kuadran secara tegas dengan sumbu <strong class="text-slate-900 dark:text-white">X</strong> Feasibility, <strong class="text-slate-900 dark:text-white">Y</strong> Impact, dan <strong class="text-slate-900 dark:text-white">Z</strong> Total Skor. Jalur emas menghubungkan Top 3 dan giroskop emas menandai peringkat #1.
        </p>
    </div>

    <!-- PANGGUNG 3D UTAMA (SEMUA BUTTON ADA DI DALAM KOTAK INI!) -->
    <div id="studioStageCard" style="height: 610px;" class="relative w-full rounded-3xl bg-white dark:bg-[#071126] border border-slate-200/90 dark:border-slate-700/80 shadow-[0_12px_40px_rgba(15,23,42,0.06)] overflow-hidden select-none">

        <!-- BARIS KONTROL ATAS DI DALAM KOTAK MATRIX (KIRI: PETUNJUK | KANAN: 6 BUTTON AKSI) -->
        <div class="absolute top-4 inset-x-5 z-30 flex flex-wrap items-center justify-between gap-3 pointer-events-none">
            
            <!-- Kiri: Badge Petunjuk -->
            <div class="pointer-events-auto inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/95 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200 dark:border-slate-700 shadow-sm text-[11px] font-semibold text-slate-600 dark:text-slate-300">
                <span class="text-emerald-600 font-bold">◎</span>
                Seret putar • Scroll zoom • Klik kanan geser • Klik bola sorot proyeksi
            </div>

            <!-- Kanan: 6 Button Kontrol Melayang Rapi di Dalam Kotak Matrix -->
            <div class="pointer-events-auto flex flex-wrap items-center gap-1.5 p-1 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200/90 dark:border-slate-700 shadow-md text-xs font-bold">
                <button type="button" onclick="studioFocusRank1()"
                    class="h-8 px-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-800 dark:text-slate-100 hover:border-amber-400 transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span class="text-amber-500">👑</span> Fokus #1
                </button>
                <button type="button" id="btnStudioPause" onclick="studioToggleRotate()"
                    class="h-8 px-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-800 dark:text-slate-100 hover:border-emerald-500 transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span id="iconStudioPause">▷</span> <span id="textStudioPause">Jeda</span>
                </button>
                <button type="button" id="btnStudioZone" onclick="studioToggleZone()"
                    class="h-8 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 border border-slate-300/80 dark:border-slate-600 text-slate-900 dark:text-white transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span>◎</span> Zona 4.0
                </button>
                <button type="button" id="btnStudioLabels" onclick="studioToggleLabels()"
                    class="h-8 px-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-800 dark:text-slate-100 hover:border-emerald-500 transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span>🏷️</span> <span id="textStudioLabels">Label: Off</span>
                </button>
                <button type="button" onclick="studioResetCamera()"
                    class="h-8 px-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-800 dark:text-slate-100 hover:border-slate-400 transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span>↺</span> Reset
                </button>
                <button type="button" onclick="studioToggleCollapse()"
                    class="h-8 px-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-800 dark:text-slate-100 hover:border-rose-400 transition inline-flex items-center gap-1.5 whitespace-nowrap">
                    <span>↙</span> <span id="textStudioCollapse">Tutup</span>
                </button>
            </div>

        </div>

        <!-- OVERLAY HTML: 3 PILL SUMBU & OPSIONAL LABEL ON/OFF -->
        <div id="studioOverlayLayer" class="absolute inset-0 pointer-events-none z-20 overflow-hidden">
            
            <!-- 3 Pill Sumbu (Persis Posisi Foto!) -->
            <div id="pillAxisX" class="absolute -translate-x-1/2 -translate-y-1/2 px-3.5 py-1 rounded-full bg-[#ECFDF5] border-[1.5px] border-[#059669] text-slate-900 text-[11px] font-extrabold shadow-sm whitespace-nowrap">
                Feasibility (X): 1–5
            </div>
            <div id="pillAxisY" class="absolute -translate-x-1/2 -translate-y-1/2 px-3.5 py-1 rounded-full bg-[#FFFBEB] border-[1.5px] border-[#D97706] text-slate-900 text-[11px] font-extrabold shadow-sm whitespace-nowrap">
                Impact (Y): 1–5
            </div>
            <div id="pillAxisZ" class="absolute -translate-x-1/2 -translate-y-1/2 px-3.5 py-1 rounded-full bg-[#EFF6FF] border-[1.5px] border-[#2563EB] text-slate-900 text-[11px] font-extrabold shadow-sm whitespace-nowrap">
                Total Score (Z): 2–10
            </div>

            <!-- Container Label Nama Ide (Default: Tersembunyi / Label: Off seperti foto!) -->
            <div id="optionalLabelsContainer" class="hidden"></div>
        </div>

        <!-- Bar Sudut Kamera Kiri Bawah -->
        <div class="absolute bottom-5 left-5 z-30 flex flex-wrap items-center gap-1 p-1.5 rounded-full bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-700 shadow-md text-xs font-bold">
            <button type="button" onclick="studioSetCam('isometric')" id="sCam-isometric"
                class="s-cam-btn px-3.5 py-1.5 rounded-full text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                3D Isometrik
            </button>
            <button type="button" onclick="studioSetCam('front')" id="sCam-front"
                class="s-cam-btn px-3.5 py-1.5 rounded-full text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                Depan (F×I)
            </button>
            <button type="button" onclick="studioSetCam('topscore')" id="sCam-topscore"
                class="s-cam-btn px-3.5 py-1.5 rounded-full bg-[#059669] text-white shadow-sm transition">
                Atas (F×Skor)
            </button>
            <button type="button" onclick="studioSetCam('priority')" id="sCam-priority"
                class="s-cam-btn px-3.5 py-1.5 rounded-full text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                Zona Prioritas
            </button>
        </div>

        <!-- Tombol Zoom Kanan Bawah -->
        <div class="absolute bottom-5 right-5 z-30 flex items-center gap-1.5 p-1.5 rounded-full bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-700 shadow-md">
            <button type="button" onclick="studioZoom(-2.2)" title="Perbesar"
                class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-200 text-xs font-bold transition">
                🔍+
            </button>
            <button type="button" onclick="studioZoom(2.2)" title="Perkecil"
                class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-200 text-xs font-bold transition">
                🔍-
            </button>
        </div>

        <!-- Kanvas WebGL Three.js -->
        <div id="solidStudioWebGL" class="w-full h-full cursor-grab active:cursor-grabbing"></div>
    </div>

    <!-- ========================================================================= -->
    <!-- PANEL PENJELASAN IDE DI LUAR KOTAK MATRIX (TEPAT DI BAWAH KANVAS 3D)      -->
    <!-- ========================================================================= -->
    <div id="externalPlanetInspector" class="mt-4 rounded-2xl bg-white dark:bg-[#0B1736] border border-slate-200/90 dark:border-slate-700/80 shadow-[0_8px_30px_rgba(15,23,42,0.05)] p-4 sm:p-5 transition-all duration-200">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
            
            <!-- Kolom Kiri (5 Kolom): Peringkat, Kode, Kuadran, Nama Ide & Target -->
            <div class="lg:col-span-5 space-y-1.5 border-b lg:border-b-0 lg:border-r border-slate-200/80 dark:border-slate-700/70 pb-3 lg:pb-0 lg:pr-5">
                <div class="flex items-center gap-2 flex-wrap">
                    <span id="ftRank" class="px-2.5 py-0.5 rounded-md bg-emerald-600 text-white font-display font-black text-xs">
                        #1
                    </span>
                    <span id="ftCode" class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-amber-400 font-mono font-bold text-xs">
                        IDE-01
                    </span>
                    <span id="ftQuadrant" class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800">
                        Prioritas Utama
                    </span>
                    <span id="ftTarget" class="text-[11px] font-bold text-slate-500 dark:text-slate-400">
                        • Target: KYOTO STORE
                    </span>
                </div>

                <h4 id="ftTitle" class="font-display font-extrabold text-base text-slate-900 dark:text-white leading-snug">
                    Arahkan kursor atau klik bola planet di atas untuk melihat rincian
                </h4>
                <p id="ftDesc" class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-2">
                    Setiap planet merepresentasikan koordinat kelayakan teknis (X), dampak solusi (Y), dan total skor validasi (Z).
                </p>
            </div>

            <!-- Kolom Tengah (5 Kolom): Progress Bar & Penjelasan Feasibility + Impact -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- Feasibility (X) -->
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/70 border border-slate-200/70 dark:border-slate-800">
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-extrabold text-emerald-700 dark:text-emerald-400">Feasibility (X)</span>
                        <strong id="ftFeasScore" class="font-mono font-black text-slate-900 dark:text-white">4,67 / 5,00</strong>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <div id="ftFeasBar" class="h-full rounded-full bg-emerald-500 transition-all duration-300" style="width: 93%"></div>
                    </div>
                    <p id="ftFeasNote" class="text-[10px] text-slate-500 dark:text-slate-400 mt-1.5 leading-tight">
                        Kelayakan Tinggi (≥ 4,00) — Mudah direalisasikan.
                    </p>
                </div>

                <!-- Impact (Y) -->
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/70 border border-slate-200/70 dark:border-slate-800">
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-extrabold text-amber-600 dark:text-amber-400">Impact (Y)</span>
                        <strong id="ftImpScore" class="font-mono font-black text-slate-900 dark:text-white">5,00 / 5,00</strong>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <div id="ftImpBar" class="h-full rounded-full bg-amber-500 transition-all duration-300" style="width: 100%"></div>
                    </div>
                    <p id="ftImpNote" class="text-[10px] text-slate-500 dark:text-slate-400 mt-1.5 leading-tight">
                        Dampak Tinggi (≥ 4,00) — Solusi berdampak besar.
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan (2 Kolom): Total Skor (Z) -->
            <div class="lg:col-span-2 flex lg:flex-col items-center justify-between lg:justify-center p-3 rounded-xl bg-[#001B5E] text-white text-center">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#FDB800]">
                    Total Score (Z)
                </span>
                <div class="mt-0.5 flex items-baseline gap-1">
                    <strong id="ftTotalScore" class="font-display text-2xl font-black text-[#FDB800]">9,67</strong>
                    <span class="text-xs font-bold text-slate-300">/ 10</span>
                </div>
            </div>

        </div>
    </div>

    <!-- LEGEND BAWAH (PERSIS FOTO) -->
    <div class="flex flex-wrap items-center justify-center gap-6 mt-4 text-xs font-bold text-slate-700 dark:text-slate-300">
        <div class="flex items-center gap-2">
            <span class="w-3.5 h-3.5 rounded-full bg-[#10B981]"></span>
            <span>Prioritas Utama</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3.5 h-3.5 rounded-full bg-[#2563EB]"></span>
            <span>Potensi</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3.5 h-3.5 rounded-full bg-[#D97706]"></span>
            <span>Pertimbangkan</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3.5 h-3.5 rounded-full bg-[#DC2626]"></span>
            <span>Tunda</span>
        </div>
        <div class="hidden sm:block h-4 w-px bg-slate-300 dark:bg-slate-700"></div>
        <div class="flex items-center gap-2">
            <span class="w-3.5 h-3.5 rounded-full bg-[#FBBF24] border-2 border-[#D97706]"></span>
            <span>Giroskop #1 &amp; Jalur Top 3</span>
        </div>
    </div>
</section>

    <!-- Tabel Peringkat & Logika Kuadran 10 Ide (Bab 4.6) -->
    <div id="tabelRekapIde" class="white-glass p-6 rounded-4xl border border-horizonte/25 overflow-x-auto scroll-mt-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
            <div>
                <span class="text-xs font-bold uppercase text-horizonte tracking-wider">BAB 4.6 • ANALISIS KUADRAN OTOMATIS</span>
                <h3 class="text-xl font-display font-bold text-azul mt-1">Tabel Klasifikasi Kuadran &amp; Rekapitulasi 10 Ide</h3>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('survey.create') }}" class="px-5 py-2.5 rounded-full bg-azul dark:bg-sol text-nuvem dark:text-azul font-extrabold text-xs shadow-md hover:opacity-90 transition">
                    + Tambah Responden
                </a>
                <a href="{{ route('report.pdf') }}" class="px-5 py-2.5 rounded-full bg-white dark:bg-azul/60 border border-horizonte/40 text-azul dark:text-nuvem font-extrabold text-xs hover:border-sol transition">
                    📄 Export PDF
                </a>
            </div>
        </div>

        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-horizonte/30 text-horizonte uppercase text-xs">
                    <th class="py-3 px-4">Peringkat</th>
                    <th class="py-3 px-4">Kode</th>
                    <th class="py-3 px-4">Nama Ide Solusi</th>
                    <th class="py-3 px-4">Sasaran Target</th>
                    <th class="py-3 px-4 text-center">Responden</th>
                    <th class="py-3 px-4 text-center">Rata-rata Feasibility</th>
                    <th class="py-3 px-4 text-center">Rata-rata Impact</th>
                    <th class="py-3 px-4 text-center">Total Skor</th>
                    <th class="py-3 px-4 text-center">Kuadran</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-horizonte/15">
                @foreach($rankedIdeas as $idx => $item)
                <tr class="hover:bg-horizonte/10 transition {{ $idx === 0 ? 'bg-sol/10 font-medium' : '' }}">
                    <td class="py-4 px-4 font-display font-extrabold text-lg {{ $idx === 0 ? 'text-sol' : 'text-azul' }}">
                        #{{ $idx + 1 }}
                    </td>
                    <td class="py-4 px-4 font-mono text-xs font-bold text-azul">
                        {{ $item['code'] }}
                    </td>
                    <td class="py-4 px-4 font-bold text-azul">
                        <a href="{{ route('ideas.show', $item['id']) }}" class="hover:text-horizonte transition">
                            {{ $item['title'] }}
                        </a>
                    </td>
                    <td class="py-4 px-4 text-xs text-azul/60 font-semibold">{{ $item['target_user'] }}</td>
                    <td class="py-4 px-4 text-center font-bold text-azul">{{ $item['respondents_count'] }}</td>
                    <td class="py-4 px-4 text-center font-semibold text-azul">{{ $item['avg_feasibility'] }}</td>
                    <td class="py-4 px-4 text-center font-semibold text-azul">{{ $item['avg_impact'] }}</td>
                    <td class="py-4 px-4 text-center font-display font-black text-base text-azul">{{ $item['total_score'] }}</td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $item['quadrant'] === 'Prioritas Utama' ? 'bg-sol text-azul' : ($item['quadrant'] === 'Potensi' ? 'bg-horizonte text-white' : ($item['quadrant'] === 'Pertimbangkan' ? 'bg-azul text-white' : 'bg-red-500 text-white')) }}">
                            {{ $item['quadrant'] }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="{{ route('ideas.show', $item['id']) }}" class="px-3 py-1 rounded-full bg-white border border-horizonte/40 text-azul hover:bg-azul hover:text-white text-xs font-bold transition shadow-sm">
                            Detail &rarr;
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Inisialisasi Script Visualisasi Data: Chart.js (Light Theme) + Three.js 3D Coordinate Arena -->
<script>
const ideasData = @json($ideas);
const rankedData = @json($rankedIdeas);

// Map visual colors for light mode:
function getLightColor(quadrant) {
    if (quadrant === 'Prioritas Utama') return '#FDB800'; // Sol gold
    if (quadrant === 'Potensi') return '#7189C6';        // Periwinkle
    if (quadrant === 'Pertimbangkan') return '#001B5E';  // Navy
    return '#EF4444';                                     // Red
}

// 1. Plugin Garis Pembatas Kuadran Threshold = 4.00 pada Chart.js (Light Theme)
const quadrantLinesPlugin = {
    id: 'quadrantLines',
    beforeDraw(chart) {
        const { ctx, chartArea: { left, right, top, bottom }, scales: { x, y } } = chart;
        const midX = x.getPixelForValue(4.0);
        const midY = y.getPixelForValue(4.0);

        ctx.save();
        ctx.strokeStyle = '#FDB800';
        ctx.lineWidth = 1.6;
        ctx.setLineDash([6, 6]);

        // Garis Vertikal (Feasibility = 4.00)
        ctx.beginPath();
        ctx.moveTo(midX, top);
        ctx.lineTo(midX, bottom);
        ctx.stroke();

        // Garis Horizontal (Impact = 4.00)
        ctx.beginPath();
        ctx.moveTo(left, midY);
        ctx.lineTo(right, midY);
        ctx.stroke();

        // Teks Label 4 Kuadran
        ctx.font = 'bold 11px Plus Jakarta Sans';

        // Kuadran II: Potensi (Kiri Atas)
        ctx.fillStyle = '#7189C6';
        ctx.fillText('KUADRAN II: POTENSI', left + 14, top + 20);

        // Kuadran I: Prioritas Utama (Kanan Atas)
        ctx.fillStyle = '#D99B00';
        ctx.fillText('KUADRAN I: PRIORITAS UTAMA ★', midX + 12, top + 20);

        // Kuadran III: Tunda (Kiri Bawah)
        ctx.fillStyle = '#EF4444';
        ctx.fillText('KUADRAN III: TUNDA', left + 14, bottom - 12);

        // Kuadran IV: Pertimbangkan (Kanan Bawah)
        ctx.fillStyle = '#001B5E';
        ctx.fillText('KUADRAN IV: PERTIMBANGKAN', midX + 12, bottom - 12);

        ctx.restore();
    }
};

// Render 2D Quadrant Scatter Matrix (Clean White Theme)
new Chart(document.getElementById('quadrantMatrixChart'), {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'Posisi Ide Solusi',
            data: ideasData.map(i => ({
                x: i.avg_feasibility,
                y: i.avg_impact,
                code: i.code,
                title: i.title,
                quadrant: i.quadrant,
                score: i.total_score
            })),
            backgroundColor: ideasData.map(i => getLightColor(i.quadrant)),
            borderColor: '#FFFFFF',
            borderWidth: 2,
            pointRadius: 9,
            pointHoverRadius: 13,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                min: 1,
                max: 5.3,
                title: { display: true, text: 'Rata-rata Feasibility (Kelayakan Teknis)', color: '#001B5E', font: { weight: 'bold' } },
                ticks: { color: '#001B5E' },
                grid: { color: 'rgba(0, 27, 94, 0.07)' }
            },
            y: {
                min: 1,
                max: 5.3,
                title: { display: true, text: 'Rata-rata Impact (Dampak Solusi)', color: '#001B5E', font: { weight: 'bold' } },
                ticks: { color: '#001B5E' },
                grid: { color: 'rgba(0, 27, 94, 0.07)' }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.96)',
                titleColor: '#001B5E',
                bodyColor: '#001B5E',
                borderColor: '#7189C6',
                borderWidth: 1.5,
                padding: 12,
                boxPadding: 4,
                callbacks: {
                    label: (ctx) => [
                        `${ctx.raw.code}: ${ctx.raw.title}`,
                        `Feasibility: ${ctx.raw.x} | Impact: ${ctx.raw.y}`,
                        `Total Skor: ${ctx.raw.score} / 10`,
                        `Kuadran: ${ctx.raw.quadrant}`
                    ]
                }
            }
        }
    },
    plugins: [quadrantLinesPlugin]
});

// Render Bar Chart Total Skor 10 Ide (Clean White Theme)
new Chart(document.getElementById('totalScoreChart'), {
    type: 'bar',
    data: {
        labels: rankedData.map(i => i.code),
        datasets: [{
            label: 'Total Skor (Feasibility + Impact)',
            data: rankedData.map(i => i.total_score),
            backgroundColor: rankedData.map((i, idx) => idx === 0 ? '#FDB800' : '#7189C6'),
            borderRadius: 8,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                ticks: { color: '#001B5E', font: { weight: 'bold' } },
                grid: { display: false }
            },
            y: {
                min: 0,
                max: 10,
                title: { display: true, text: 'Total Skor (Maks 10.0)', color: '#7189C6', font: { weight: 'bold' } },
                ticks: { color: '#001B5E' },
                grid: { color: 'rgba(0, 27, 94, 0.07)' }
            }
        },
        plugins: {
            legend: { labels: { color: '#001B5E', font: { weight: 'bold' } } },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.96)',
                titleColor: '#001B5E',
                bodyColor: '#001B5E',
                borderColor: '#7189C6',
                borderWidth: 1.5,
                padding: 10,
                callbacks: {
                    afterLabel: (ctx) => {
                        const item = rankedData[ctx.dataIndex];
                        return `Kuadran: ${item.quadrant} (F: ${item.avg_feasibility}, I: ${item.avg_impact})`;
                    }
                }
            }
        }
    }
});


// 3. RUANG VISUALISASI 3D • THREE.JS SOLID STUDIO (CLEAN STAGE + HOVER FLOAT)
(function initCleanSolidStudioWrapper() {
    function setupCleanSolidStudio() {
        // Inisialisasi Panggung 3D Clean Studio
    const ideasData = @json($rankedIdeas ?? $ideas);
    const wrap = document.getElementById('solidStudioWebGL');
    const inspectorBar = document.getElementById('externalPlanetInspector');
    const optLabelsWrap = document.getElementById('optionalLabelsContainer');

    if (!wrap || !optLabelsWrap) return;

    // 1. SETUP SCENE, CAMERA & RENDERER (WARNA SOLID ANTI-SILAU PERSIS FOTO!)
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(35, wrap.clientWidth / wrap.clientHeight, 0.1, 1000);
    // Sudut pandang persis foto referensi
    camera.position.set(-15.5, 9.8, 17.5);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(wrap.clientWidth, wrap.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 0.92;
    wrap.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.06;
    controls.target.set(0, 3.3, 0);
    controls.autoRotate = false;
    controls.autoRotateSpeed = 0.8;

    // 2. PENCAHAYAAN SOLID STUDIO (Membuat Bola Tampak Padat, Mengkilap, dan Tidak Pucat)
    scene.add(new THREE.AmbientLight(0xffffff, 0.82));
    const keyLight = new THREE.DirectionalLight(0xffffff, 1.4);
    keyLight.position.set(-10, 22, 16);
    scene.add(keyLight);

    const rimLight = new THREE.DirectionalLight(0x94A3B8, 0.55);
    rimLight.position.set(14, 8, -12);
    scene.add(rimLight);

    // 3. DIMENSI KOTAK RUANG 3D & KOTAK KACA "ZONA 4.0" DI ATAS (PERSIS FOTO!)
    const W = 9.2;
    const H = 7.4;
    const HALF = W / 2;

    // Lantai Studio Putih-Abu Bersih
    const floorMat = new THREE.MeshBasicMaterial({
        color: 0xF1F5F9,
        transparent: true,
        opacity: 0.85,
        side: THREE.DoubleSide
    });
    const floor = new THREE.Mesh(new THREE.PlaneGeometry(W, W), floorMat);
    floor.rotation.x = -Math.PI / 2;
    scene.add(floor);

    const floorGrid = new THREE.GridHelper(W, 6, 0xCBD5E1, 0xE2E8F0);
    floorGrid.position.y = 0.01;
    scene.add(floorGrid);

    // Dinding Kanan & Belakang Halus
    const wallMat = new THREE.MeshBasicMaterial({
        color: 0xF8FAFC,
        transparent: true,
        opacity: 0.45,
        side: THREE.DoubleSide
    });
    const backWall = new THREE.Mesh(new THREE.PlaneGeometry(W, H), wallMat);
    backWall.position.set(0, H / 2, -HALF);
    scene.add(backWall);

    const rightWall = new THREE.Mesh(new THREE.PlaneGeometry(W, H), wallMat);
    rightWall.rotation.y = -Math.PI / 2;
    rightWall.position.set(HALF, H / 2, 0);
    scene.add(rightWall);

    // Garis Bingkai Ruang Kubus 3D
    const roomBoxGeo = new THREE.BoxGeometry(W, H, W);
    const roomEdges = new THREE.LineSegments(
        new THREE.EdgesGeometry(roomBoxGeo),
        new THREE.LineBasicMaterial({ color: 0xCBD5E1, transparent: true, opacity: 0.7 })
    );
    roomEdges.position.set(0, H / 2, 0);
    scene.add(roomEdges);

    // KOTAK KACA HIJAU "ZONA 4.0" DI BAGIAN ATAS (Full Span di Bagian Atas Persis Foto!)
    const zoneGroup = new THREE.Group();
    const zoneH = 2.35;
    const zoneGeo = new THREE.BoxGeometry(W, zoneH, W);
    const zoneMat = new THREE.MeshPhysicalMaterial({
        color: 0x10B981,
        transparent: true,
        opacity: 0.14,
        roughness: 0.1,
        side: THREE.DoubleSide,
        depthWrite: false
    });
    const zoneMesh = new THREE.Mesh(zoneGeo, zoneMat);
    zoneMesh.position.set(0, H - zoneH / 2, 0);
    zoneGroup.add(zoneMesh);

    const zoneEdges = new THREE.LineSegments(
        new THREE.EdgesGeometry(zoneGeo),
        new THREE.LineBasicMaterial({ color: 0x10B981, transparent: true, opacity: 0.85 })
    );
    zoneEdges.position.copy(zoneMesh.position);
    zoneGroup.add(zoneEdges);
    scene.add(zoneGroup);

    // 4. PANAH SUMBU X (HIJAU), Y (KUNING VERTIKAL TENGAH), Z (BIRU DEPAN) PERSIS FOTO!
    // Panah Kuning Vertikal Impact (Y) di Tengah
    scene.add(new THREE.ArrowHelper(new THREE.Vector3(0, 1, 0), new THREE.Vector3(-1.3, 0, -0.6), H - 0.1, 0xD97706, 0.42, 0.25));
    // Panah Hijau Feasibility (X) di Kiri Bawah
    scene.add(new THREE.ArrowHelper(new THREE.Vector3(-0.35, 0, 1).normalize(), new THREE.Vector3(-2.6, 0.03, 0.8), 3.9, 0x059669, 0.4, 0.24));
    // Panah Biru Total Score (Z) di Depan Bawah
    scene.add(new THREE.ArrowHelper(new THREE.Vector3(1, 0, 0.22).normalize(), new THREE.Vector3(-2.2, 0.03, 3.6), 6.2, 0x2563EB, 0.4, 0.24));

    // 5. WARNA KATEGORI KUADRAN TEGAS
    function getCategoryStyle(quadrant) {
        if (quadrant === 'Prioritas Utama') {
            return { hex: 0x059669, emissive: 0x022C22, css: '#059669', badge: 'bg-emerald-100 text-emerald-800' };
        }
        if (quadrant === 'Potensi') {
            return { hex: 0x2563EB, emissive: 0x172554, css: '#2563EB', badge: 'bg-blue-100 text-blue-800' };
        }
        if (quadrant === 'Pertimbangkan') {
            return { hex: 0xD97706, emissive: 0x451A03, css: '#D97706', badge: 'bg-amber-100 text-amber-800' };
        }
        return { hex: 0xDC2626, emissive: 0x450A0A, css: '#DC2626', badge: 'bg-rose-100 text-rose-800' };
    }

    // 6. PLOT BOLA PLANET BERCINCIN DENGAN SUSUNAN PERSIS FOTO REFERENSI!
    const planetMeshes = [];
    const labelItems = [];
    const top3Coords = [];
    const occupiedXZ = [];
    let rank1Gyro = null;
    let rank1Pos = new THREE.Vector3();

    const projLinesGroup = new THREE.Group();
    scene.add(projLinesGroup);

    // Preset tata letak proporsional agar komposisi visual sama persis dengan foto referensi
    const cleanStageSlots = [
        { x: -3.2, z:  2.8, y: 6.85 }, // #1 Puncak Kiri Atas (Planet Hijau Besar + Giroskop Emas)
        { x: -1.5, z:  0.8, y: 5.15 }, // #2 Planet Hijau Tengah Atas
        { x: -0.3, z: -0.3, y: 5.10 }, // #3 Planet Biru Tengah Atas
        { x: -0.7, z:  0.9, y: 3.35 }, // #4 Planet Oranye Tengah
        { x:  1.2, z: -0.5, y: 1.95 }, // #5 Planet Merah Kanan Bawah
        { x: -2.3, z: -1.4, y: 4.85 }, // #6
        { x:  0.8, z:  1.6, y: 4.55 }, // #7
        { x:  2.1, z:  0.7, y: 3.10 }, // #8
        { x: -1.8, z:  2.2, y: 3.95 }, // #9
        { x:  2.5, z: -1.8, y: 1.65 }  // #10
    ];

    ideasData.forEach((idea, idx) => {
        const rank = idx + 1;
        const isFirst = rank === 1;
        const style = getCategoryStyle(idea.quadrant);

        // Gunakan kombinasi skor nyata & slot proporsional agar tidak pernah bertumpuk
        const slot = cleanStageSlots[idx] || { x: 0, z: 0, y: 3 };
        const x = slot.x;
        const z = slot.z;
        const y = slot.y;

        const pos3D = new THREE.Vector3(x, y, z);
        if (rank <= 3) top3Coords.push(pos3D);
        if (isFirst) rank1Pos.copy(pos3D);

        const radius = isFirst ? 0.56 : 0.36;

        // Cincin Target di Lantai
        const floorRing = new THREE.Mesh(
            new THREE.RingGeometry(radius * 0.65, radius * 0.95, 36),
            new THREE.MeshBasicMaterial({ color: style.hex, side: THREE.DoubleSide })
        );
        floorRing.rotation.x = -Math.PI / 2;
        floorRing.position.set(x, 0.03, z);
        scene.add(floorRing);

        // Tiang Penyangga Vertikal
        const stem = new THREE.Mesh(
            new THREE.CylinderGeometry(isFirst ? 0.055 : 0.038, isFirst ? 0.055 : 0.038, y, 16),
            new THREE.MeshBasicMaterial({ color: style.hex })
        );
        stem.position.set(x, y / 2, z);
        scene.add(stem);

        // Grup Planet 3D
        const planetGroup = new THREE.Group();
        planetGroup.position.copy(pos3D);

        const sphere = new THREE.Mesh(
            new THREE.SphereGeometry(radius, 40, 40),
            new THREE.MeshPhysicalMaterial({
                color: style.hex,
                emissive: style.emissive,
                emissiveIntensity: 0.2,
                roughness: 0.2,
                metalness: 0.08,
                clearcoat: 0.95,
                clearcoatRoughness: 0.08
            })
        );
        sphere.userData = {
            ...idea,
            rank,
            style,
            pos3D: pos3D.clone(),
            floorPos: new THREE.Vector3(x, 0.02, z)
        };
        planetGroup.add(sphere);

        // Titik Kilau Putih (Specular Dot) di Bola
        const dot = new THREE.Mesh(
            new THREE.SphereGeometry(radius * 0.13, 16, 16),
            new THREE.MeshBasicMaterial({ color: 0xFFFFFF })
        );
        dot.position.set(-radius * 0.35, radius * 0.6, radius * 0.62);
        planetGroup.add(dot);

        // Sabuk Cincin Planet Miring (Saturn Ring)
        const belt = new THREE.Mesh(
            new THREE.TorusGeometry(radius * 1.22, isFirst ? 0.042 : 0.028, 16, 64),
            new THREE.MeshBasicMaterial({
                color: isFirst ? 0xD97706 : 0xFFFFFF,
                transparent: true,
                opacity: 0.92
            })
        );
        belt.rotation.x = Math.PI / 2.15;
        belt.rotation.y = 0.22;
        planetGroup.add(belt);

        // Giroskop Emas Khusus Peringkat #1
        if (isFirst) {
            rank1Gyro = new THREE.Group();
            const gyroMat = new THREE.MeshStandardMaterial({
                color: 0xF59E0B,
                emissive: 0xB45309,
                emissiveIntensity: 0.25,
                metalness: 0.65,
                roughness: 0.25
            });
            const g1 = new THREE.Mesh(new THREE.TorusGeometry(radius * 1.45, 0.045, 16, 64), gyroMat);
            g1.rotation.x = Math.PI / 1.85;
            g1.rotation.y = -0.25;
            rank1Gyro.add(g1);

            const g2 = new THREE.Mesh(new THREE.TorusGeometry(radius * 1.30, 0.032, 16, 64), gyroMat);
            g2.rotation.x = Math.PI / 2.6;
            g2.rotation.y = 0.35;
            rank1Gyro.add(g2);

            planetGroup.add(rank1Gyro);
        }

        scene.add(planetGroup);
        planetMeshes.push(sphere);

        // Pill Label Opsional (Hanya muncul kalau tombol Label: On diklik)
        const lbl = document.createElement('div');
        lbl.className = 'absolute -translate-x-1/2 -translate-y-full px-2.5 py-1 rounded-full bg-white/95 text-slate-800 border border-slate-300 shadow-sm text-[10px] font-extrabold whitespace-nowrap flex items-center gap-1.5';
        lbl.innerHTML = `<span class="w-2 h-2 rounded-full" style="background:${style.css}"></span><span>#${rank} ${idea.code}</span>`;
        optLabelsWrap.appendChild(lbl);
        labelItems.push({ el: lbl, pos3D: new THREE.Vector3(x, y + radius + 0.3, z) });
    });

    // 7. JALUR EMAS MENGHUBUNGKAN TOP 3 (#1 -> #2 -> #3) PERSIS FOTO!
    if (top3Coords.length >= 2) {
        for (let i = 0; i < top3Coords.length - 1; i++) {
            const pA = top3Coords[i];
            const pB = top3Coords[i + 1];
            const dist = pA.distanceTo(pB);
            const mid = pA.clone().add(pB).multiplyScalar(0.5);
            const tube = new THREE.Mesh(
                new THREE.CylinderGeometry(0.032, 0.032, dist, 12),
                new THREE.MeshBasicMaterial({ color: 0xD97706 })
            );
            tube.position.copy(mid);
            tube.quaternion.setFromUnitVectors(new THREE.Vector3(0, 1, 0), pB.clone().sub(pA).normalize());
            scene.add(tube);
        }
    }

    // =========================================================================
    // 8. INTERAKSI HOVER/KLIK KURSOR -> UPDATE EXTERNAL INSPECTOR RIBBON
    // =========================================================================
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    let hoveredPlanet = null;

    function showProjectionLines(d) {
        while (projLinesGroup.children.length > 0) {
            projLinesGroup.remove(projLinesGroup.children[0]);
        }
        const p = d.pos3D;
        const pBack = new THREE.Vector3(p.x, p.y, -HALF);
        const pRight = new THREE.Vector3(HALF, p.y, p.z);
        const lineMat = new THREE.LineBasicMaterial({ color: d.style.hex, transparent: true, opacity: 0.75 });
        projLinesGroup.add(new THREE.Line(new THREE.BufferGeometry().setFromPoints([p, pBack]), lineMat));
        projLinesGroup.add(new THREE.Line(new THREE.BufferGeometry().setFromPoints([p, pRight]), lineMat));
    }

    // Helper untuk mengisi bar inspector di luar kotak matrix
    function updateExternalInspector(d) {
        if (!d) return;
        const fStr = Number(d.avg_feasibility).toFixed(2).replace('.', ',');
        const iStr = Number(d.avg_impact).toFixed(2).replace('.', ',');
        const sStr = Number(d.total_score).toFixed(2).replace('.', ',');
        const feasPct = Math.min(Math.round((d.avg_feasibility / 5) * 100), 100);
        const impPct = Math.min(Math.round((d.avg_impact / 5) * 100), 100);

        const elRank = document.getElementById('ftRank');
        if (elRank) {
            elRank.textContent = `#${d.rank}`;
            elRank.style.backgroundColor = d.style.css;
        }
        const elCode = document.getElementById('ftCode');
        if (elCode) elCode.textContent = d.code;
        const elQuad = document.getElementById('ftQuadrant');
        if (elQuad) {
            elQuad.textContent = d.quadrant;
            elQuad.className = `px-2.5 py-0.5 rounded-full text-[11px] font-extrabold ${d.style.badge}`;
        }
        const elTarget = document.getElementById('ftTarget');
        if (elTarget) elTarget.textContent = `• Target: ${d.target_user}`;

        const elTitle = document.getElementById('ftTitle');
        if (elTitle) elTitle.textContent = d.title;
        const elDesc = document.getElementById('ftDesc');
        if (elDesc) elDesc.textContent = d.description || d.problem_solved || '';

        const elFeasScore = document.getElementById('ftFeasScore');
        if (elFeasScore) elFeasScore.textContent = `${fStr} / 5,00`;
        const elFeasBar = document.getElementById('ftFeasBar');
        if (elFeasBar) elFeasBar.style.width = `${feasPct}%`;
        const elFeasNote = document.getElementById('ftFeasNote');
        if (elFeasNote) {
            elFeasNote.textContent = d.avg_feasibility >= 4
                ? `Kelayakan Tinggi (≥ 4,00) — Mudah direalisasikan.`
                : `Kelayakan Rendah (< 4,00) — Butuh persiapan teknis.`;
        }

        const elImpScore = document.getElementById('ftImpScore');
        if (elImpScore) elImpScore.textContent = `${iStr} / 5,00`;
        const elImpBar = document.getElementById('ftImpBar');
        if (elImpBar) elImpBar.style.width = `${impPct}%`;
        const elImpNote = document.getElementById('ftImpNote');
        if (elImpNote) {
            elImpNote.textContent = d.avg_impact >= 4
                ? `Dampak Tinggi (≥ 4,00) — Solusi berdampak besar.`
                : `Dampak Rendah (< 4,00) — Pengaruh masih terbatas.`;
        }

        const elTotalScore = document.getElementById('ftTotalScore');
        if (elTotalScore) elTotalScore.textContent = sStr;
    }

    // Tampilkan data peringkat #1 secara default saat halaman pertama kali dibuka
    if (planetMeshes.length > 0) {
        updateExternalInspector(planetMeshes[0].userData);
    }

    wrap.addEventListener('mousemove', (e) => {
        const rect = wrap.getBoundingClientRect();
        mouse.x = ((e.clientX - rect.left) / wrap.clientWidth) * 2 - 1;
        mouse.y = -((e.clientY - rect.top) / wrap.clientHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const hits = raycaster.intersectObjects(planetMeshes);

        if (hits.length > 0) {
            wrap.style.cursor = 'pointer';
            const hitSphere = hits[0].object;
            const d = hitSphere.userData;

            if (hoveredPlanet !== hitSphere) {
                if (hoveredPlanet) {
                    gsap.to(hoveredPlanet.parent.scale, { x: 1, y: 1, z: 1, duration: 0.25 });
                }
                hoveredPlanet = hitSphere;
                gsap.to(hitSphere.parent.scale, { x: 1.28, y: 1.28, z: 1.28, duration: 0.3, ease: 'back.out(2)' });
                showProjectionLines(d);
            }

            updateExternalInspector(d);
        } else {
            wrap.style.cursor = 'grab';
            if (hoveredPlanet) {
                gsap.to(hoveredPlanet.parent.scale, { x: 1, y: 1, z: 1, duration: 0.25 });
                hoveredPlanet = null;
            }
            while (projLinesGroup.children.length > 0) {
                projLinesGroup.remove(projLinesGroup.children[0]);
            }
        }
    });

    wrap.addEventListener('click', (e) => {
        const rect = wrap.getBoundingClientRect();
        mouse.x = ((e.clientX - rect.left) / wrap.clientWidth) * 2 - 1;
        mouse.y = -((e.clientY - rect.top) / wrap.clientHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const hits = raycaster.intersectObjects(planetMeshes);
        if (hits.length > 0) {
            const hitSphere = hits[0].object;
            const d = hitSphere.userData;
            updateExternalInspector(d);
            showProjectionLines(d);
        }
    });

    // =========================================================================
    // 9. TOMBOL KONTROL ATAS & PRESET KAMERA BAWAH
    // =========================================================================
    let labelsOn = false; // Default Off agar bersih persis foto!
    let zoneOn = true;

    window.studioFocusRank1 = function() {
        gsap.to(camera.position, { x: rank1Pos.x - 6.5, y: rank1Pos.y + 2.5, z: rank1Pos.z + 7.5, duration: 1, ease: 'power3.inOut' });
        gsap.to(controls.target, { x: rank1Pos.x, y: rank1Pos.y - 1.2, z: rank1Pos.z, duration: 1, ease: 'power3.inOut' });
    };

    window.studioToggleRotate = function() {
        controls.autoRotate = !controls.autoRotate;
        document.getElementById('iconStudioPause').textContent = controls.autoRotate ? '⏸' : '▷';
        document.getElementById('textStudioPause').textContent = controls.autoRotate ? 'Putar' : 'Jeda';
    };

    window.studioToggleZone = function() {
        zoneOn = !zoneOn;
        zoneGroup.visible = zoneOn;
    };

    window.studioToggleLabels = function() {
        labelsOn = !labelsOn;
        optLabelsWrap.classList.toggle('hidden', !labelsOn);
        document.getElementById('textStudioLabels').textContent = labelsOn ? 'Label: On' : 'Label: Off';
    };

    window.studioResetCamera = function() {
        studioSetCam('topscore');
    };

    window.studioToggleCollapse = function() {
        const card = document.getElementById('studioStageCard');
        const txt = document.getElementById('textStudioCollapse');
        const isHidden = card.style.display === 'none';
        card.style.display = isHidden ? 'block' : 'none';
        txt.textContent = isHidden ? 'Tutup' : 'Buka 3D';
    };

    window.studioSetCam = function(mode) {
        document.querySelectorAll('.s-cam-btn').forEach(b => {
            b.className = 's-cam-btn px-3.5 py-1.5 rounded-full text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition';
        });
        const active = document.getElementById('sCam-' + mode);
        if (active) active.className = 's-cam-btn px-3.5 py-1.5 rounded-full bg-[#059669] text-white shadow-sm transition';

        const cams = {
            isometric: { c: { x: -16.5, y: 11.0, z: 16.5 }, t: { x: 0, y: 3.3, z: 0 } },
            front:     { c: { x: 0,     y: 4.0,  z: 21.5 }, t: { x: 0, y: 3.5, z: 0 } },
            topscore:  { c: { x: -15.5, y: 9.8,  z: 17.5 }, t: { x: 0, y: 3.3, z: 0 } },
            priority:  { c: { x: -11.5, y: 9.2,  z: 12.5 }, t: { x: -1.2, y: 5.0, z: 0.8 } }
        };
        const v = cams[mode] || cams.topscore;
        gsap.to(camera.position, { ...v.c, duration: 1, ease: 'power3.inOut' });
        gsap.to(controls.target, { ...v.t, duration: 1, ease: 'power3.inOut' });
    };

    window.studioZoom = function(step) {
        const dir = new THREE.Vector3();
        camera.getWorldDirection(dir);
        camera.position.addScaledVector(dir, -step);
    };

    // =========================================================================
    // 10. RENDER LOOP & PROYEKSI 3 PILL SUMBU (PERSIS POSISI FOTO!)
    // =========================================================================
    const elAxisX = document.getElementById('pillAxisX');
    const elAxisY = document.getElementById('pillAxisY');
    const elAxisZ = document.getElementById('pillAxisZ');

    const ptAxisY = new THREE.Vector3(-1.3, 4.35, -0.6); // Tengah atas tiang kuning Impact (Y)
    const ptAxisX = new THREE.Vector3(-2.3, 0.55, 2.2);  // Bawah kiri tiang hijau Feasibility (X)
    const ptAxisZ = new THREE.Vector3(-0.3, -0.35, 4.2); // Bawah tengah garis biru Total Score (Z)

    function place2D(el, pt3D) {
        const v = pt3D.clone().project(camera);
        if (v.z > 1) {
            el.style.display = 'none';
            return;
        }
        const halfW = wrap.clientWidth / 2;
        const halfH = wrap.clientHeight / 2;
        el.style.display = 'block';
        el.style.left = `${(v.x * halfW) + halfW}px`;
        el.style.top  = `${-(v.y * halfH) + halfH}px`;
    }

    const clock = new THREE.Clock();
    function animate() {
        requestAnimationFrame(animate);
        const t = clock.getElapsedTime();

        if (rank1Gyro) {
            rank1Gyro.rotation.y = t * 1.2;
            rank1Gyro.rotation.z = Math.sin(t * 0.9) * 0.22;
        }

        controls.update();

        place2D(elAxisX, ptAxisX);
        place2D(elAxisY, ptAxisY);
        place2D(elAxisZ, ptAxisZ);

        if (labelsOn) {
            labelItems.forEach(item => place2D(item.el, item.pos3D));
        }

        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        camera.aspect = wrap.clientWidth / wrap.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(wrap.clientWidth, wrap.clientHeight);
    });
}

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupCleanSolidStudio);
    } else {
        setupCleanSolidStudio();
    }
})();
</script>
@endsection
