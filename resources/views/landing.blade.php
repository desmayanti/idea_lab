@extends('layouts.app')

@section('content')
<!-- HERO SECTION GAYA EDITORIAL ENTERPRISE 3D -->
<section class="relative min-h-[88vh] flex items-center justify-center overflow-hidden pt-6 pb-16">

    <!-- LAYER 1 (Belakang): Tipografi Editorial Raksasa di Belakang Objek 3D -->
    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none select-none z-0">
        <span class="font-display font-extrabold text-[15vw] leading-none tracking-tighter text-azul/[0.05] dark:text-nuvem/[0.03]">
            IDEA LAB
        </span>
        <span class="font-display font-bold text-[3.5vw] tracking-[0.35em] text-horizonte/25 dark:text-horizonte/20 uppercase -mt-4">
            COMMUNITY VALIDATION HUB
        </span>
    </div>

    <!-- LAYER 2 (Tengah): Kanvas 3D Glossy Studio Sculpture (Interaktif Mouse & Drag) -->
    <div id="pinterestWhite3D" class="absolute inset-0 w-full h-full z-10 cursor-grab active:cursor-grabbing"></div>

    <!-- LAYER 3 (Depan): Bento Grid & Editorial Content Mengelilingi Objek 3D -->
    <div class="relative z-20 max-w-7xl w-full mx-auto px-6 grid lg:grid-cols-12 gap-8 items-center pointer-events-none">

        <!-- Kolom Kiri: Headline, Live Metric Counter, & CTA -->
        <div class="lg:col-span-5 space-y-6 pointer-events-auto">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full white-glass text-azul dark:text-nuvem text-xs font-extrabold tracking-wider uppercase shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Live Community Ideation Hub</span>
            </div>

            <h1 class="font-display text-4xl sm:text-5xl md:text-6xl font-extrabold leading-[1.08] tracking-tight text-azul dark:text-nuvem">
                Test Ideas.<br>
                <span class="text-horizonte">Analyze Data.</span><br>
                <span class="inline-block px-4 py-1 rounded-2xl bg-sol text-azul mt-1">Build Better.</span>
            </h1>

            <p class="text-azul/75 dark:text-slate-300 text-sm md:text-base leading-relaxed">
                Platform validasi inovasi multi-proyek berbasis kuadran <strong class="text-azul dark:text-nuvem">Feasibility</strong> (Kelayakan) dan <strong class="text-azul dark:text-nuvem">Impact</strong> (Dampak) — terbuka untuk UMKM, mahasiswa, dan komunitas publik.
            </p>

            <!-- Real-time Live Counters Row -->
            <div class="grid grid-cols-3 gap-3 p-3.5 rounded-2xl bg-white/70 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200/80 dark:border-slate-800 shadow-sm text-center">
                <div>
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 dark:text-slate-400 block">Ide Aktif</span>
                    <strong class="font-display text-xl font-black text-azul dark:text-nuvem">{{ $totalIdeas }}</strong>
                </div>
                <div class="border-x border-slate-200 dark:border-slate-800">
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 dark:text-slate-400 block">Responden</span>
                    <strong class="font-display text-xl font-black text-sol">{{ $totalRespondents }}</strong>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 dark:text-slate-400 block">Suara Masuk</span>
                    <strong class="font-display text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $totalVotes }}</strong>
                </div>
            </div>

            <!-- Tombol Aksi Utama -->
            <div class="flex flex-wrap items-center gap-3 pt-1">
                <a href="{{ route('survey.create') }}" class="px-6 py-3.5 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul font-extrabold text-xs sm:text-sm hover:opacity-90 transition shadow-lg hover:scale-105 active:scale-95 duration-200">
                    Isi Survei Validasi →
                </a>
                <a href="{{ route('ideas.create') }}" class="px-5 py-3.5 rounded-xl bg-sol dark:bg-nuvem text-azul font-black text-xs sm:text-sm hover:brightness-105 transition shadow-md hover:scale-105 active:scale-95 duration-200 flex items-center gap-1.5">
                    <span>✨</span> + Ajukan Ide Baru
                </a>
                <a href="{{ route('dashboard') }}" class="px-5 py-3.5 rounded-xl white-glass text-azul dark:text-nuvem font-bold text-xs sm:text-sm hover:border-azul transition">
                    Matriks 3D
                </a>
            </div>
        </div>

        <!-- Kolom Tengah Kosong (Ruang Pamer Patung 3D Interaktif) -->
        <div class="lg:col-span-3 h-70 lg:h-120"></div>

        <!-- Kolom Kanan: Floating Bento Cards ala Pinterest -->
        <div class="lg:col-span-4 space-y-4 pointer-events-auto">
            
            <!-- Bento Card 1: Ide Terpopuler / Peringkat #1 Saat Ini -->
            @if($topIdea)
            <div data-tilt class="white-glass p-5 rounded-3xl border-2 border-sol/80 space-y-3 shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full bg-sol text-azul font-extrabold text-[10px] uppercase tracking-wider flex items-center gap-1">
                        <span>★</span> Prioritas Utama #1
                    </span>
                    <span class="font-mono font-bold text-xs text-horizonte">{{ $topIdea['code'] }}</span>
                </div>
                <h3 class="font-display font-extrabold text-base text-azul dark:text-nuvem leading-snug line-clamp-2">
                    {{ $topIdea['title'] }}
                </h3>
                <div class="grid grid-cols-3 gap-2 pt-1 text-center">
                    <div class="p-2 rounded-xl bg-nuvem dark:bg-slate-800/80">
                        <span class="text-[9px] text-horizonte font-bold block">FEASIBILITY</span>
                        <strong class="font-display text-base text-azul dark:text-nuvem">{{ $topIdea['avg_feasibility'] }}</strong>
                    </div>
                    <div class="p-2 rounded-xl bg-nuvem dark:bg-slate-800/80">
                        <span class="text-[9px] text-horizonte font-bold block">IMPACT</span>
                        <strong class="font-display text-base text-azul dark:text-nuvem">{{ $topIdea['avg_impact'] }}</strong>
                    </div>
                    <div class="p-2 rounded-xl bg-azul text-nuvem">
                        <span class="text-[9px] text-sol font-bold block">TOTAL SKOR</span>
                        <strong class="font-display text-base text-sol">{{ $topIdea['total_score'] }}</strong>
                    </div>
                </div>
            </div>
            @endif

            <!-- Bento Card 2: Interactive 3D Guide -->
            <div data-tilt class="white-glass p-4 rounded-[22px] flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 shrink-0 rounded-xl bg-horizonte/20 flex items-center justify-center text-azul dark:text-sol font-display font-black text-base">
                    3D
                </div>
                <div>
                    <h4 class="font-bold text-xs text-azul dark:text-nuvem">Interactive Kinetic Sculpture</h4>
                    <p class="text-[11px] text-azul/65 dark:text-slate-400">Putar patung 3D dengan kursor mouse untuk melihat interaksi kinetik.</p>
                </div>
            </div>

            <!-- Bento Card 3: Banner Buka Ide Baru untuk Publik -->
            <div class="p-4 rounded-[22px] bg-linear-to-r from-azul to-[#002D9C] text-nuvem space-y-2 shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase text-sol tracking-wider">Senarai KIK &amp; UMKM</span>
                    <span class="text-xs">🚀</span>
                </div>
                <h4 class="font-display font-bold text-xs leading-snug">
                    Ingin Memvalidasi Ide Bisnis Anda Sendiri?
                </h4>
                <p class="text-[11px] text-nuvem/75 leading-relaxed">
                    Daftarkan topik inovasi Anda, sebar formulir ke responden, dan dapatkan analisis kuadran instan.
                </p>
                <div class="pt-1">
                    <a href="{{ route('ideas.create') }}" class="inline-block px-3 py-1.5 rounded-lg bg-sol text-azul text-xs font-black hover:brightness-105 transition">
                        + Buat Sesi Validasi Baru
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FLOATING GLASS TOP-3 LEADERBOARD & SMOOTH TICKER (TANPA SCROLLBAR KASAR) -->
<div class="relative z-30 max-w-6xl mx-auto px-6 -mt-8 mb-14">
    <div class="rounded-2xl bg-white/85 dark:bg-[#071126]/90 backdrop-blur-2xl border border-slate-200/90 dark:border-[#7189C6]/30 shadow-[0_20px_50px_rgba(0,27,94,0.08)] p-2.5 flex flex-col md:flex-row items-center gap-3 overflow-hidden">
        
        <!-- Badge Kiri: Live Ranking -->
        <div class="shrink-0 px-4 py-2 rounded-xl bg-[#001B5E] dark:bg-[#FDB800] text-white dark:text-[#001B5E] flex items-center gap-2 shadow-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FDB800] dark:bg-[#001B5E] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FDB800] dark:bg-[#001B5E]"></span>
            </span>
            <span class="font-display font-extrabold text-xs tracking-wider uppercase">Live Top 3</span>
        </div>

        <!-- Area Marquee Halus Tanpa Scrollbar (Dengan Gradient Fade Kiri-Kanan) -->
        <div class="relative flex-1 w-full overflow-hidden mask-r-from-96% mask-l-from-96%">
            <div class="flex items-center gap-4 w-max animate-marquee hover:[animation-play-state:paused]">
                @foreach($rankedIdeas->take(5) as $idx => $item)
                <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2.5 px-4 py-2 rounded-xl bg-slate-50/90 dark:bg-[#001B5E]/60 border border-slate-200/80 dark:border-[#7189C6]/25 hover:border-[#FDB800] transition">
                    <span class="w-6 h-6 rounded-lg flex items-center justify-center font-display font-black text-xs {{ $idx === 0 ? 'bg-[#FDB800] text-[#001B5E]' : 'bg-[#001B5E] text-white dark:bg-[#7189C6]/30' }}">
                        #{{ $idx + 1 }}
                    </span>
                    <span class="font-mono text-[11px] font-bold text-[#7189C6]">{{ $item['code'] }}</span>
                    <span class="text-xs font-bold text-[#001B5E] dark:text-[#F4F5F7] group-hover:text-[#FDB800] transition">
                        {{ $item['title'] }}
                    </span>
                    <span class="px-2 py-0.5 rounded-md bg-[#FDB800]/20 text-[#001B5E] dark:text-[#FDB800] font-mono text-[11px] font-extrabold">
                        {{ number_format($item['total_score'], 2) }}
                    </span>
                </a>
                @endforeach

                <!-- Duplikat Loop untuk Animasi Tanpa Putus -->
                @foreach($rankedIdeas->take(5) as $idx => $item)
                <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2.5 px-4 py-2 rounded-xl bg-slate-50/90 dark:bg-[#001B5E]/60 border border-slate-200/80 dark:border-[#7189C6]/25 hover:border-[#FDB800] transition">
                    <span class="w-6 h-6 rounded-lg flex items-center justify-center font-display font-black text-xs {{ $idx === 0 ? 'bg-[#FDB800] text-[#001B5E]' : 'bg-[#001B5E] text-white dark:bg-[#7189C6]/30' }}">
                        #{{ $idx + 1 }}
                    </span>
                    <span class="font-mono text-[11px] font-bold text-[#7189C6]">{{ $item['code'] }}</span>
                    <span class="text-xs font-bold text-[#001B5E] dark:text-[#F4F5F7] group-hover:text-[#FDB800] transition">
                        {{ $item['title'] }}
                    </span>
                    <span class="px-2 py-0.5 rounded-md bg-[#FDB800]/20 text-[#001B5E] dark:text-[#FDB800] font-mono text-[11px] font-extrabold">
                        {{ number_format($item['total_score'], 2) }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Tombol Lihat Semua -->
        <a href="{{ route('dashboard') }}" class="shrink-0 px-3.5 py-2 rounded-xl text-xs font-extrabold text-[#001B5E] dark:text-[#FDB800] hover:bg-slate-100 dark:hover:bg-[#001B5E] transition whitespace-nowrap">
            Matriks →
        </a>
    </div>
</div>

<style>
    @keyframes marqueeScroll {
        0%   { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        animation: marqueeScroll 28s linear infinite;
    }
</style>

<!-- DYNAMIC REAL-TIME VALIDATION HUB (MULTI-PROJECT / COMMUNITY SHOWCASE) -->
<section class="max-w-7xl mx-auto px-6 py-14 space-y-10">

    <!-- Section Header + CTA Ajukan Ide -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-horizonte/30 dark:border-slate-800 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-horizonte/20 text-azul dark:text-nuvem font-extrabold text-xs uppercase tracking-wider">
                COMMUNITY VALIDATION FEED
            </div>
            <h2 class="font-display text-2xl md:text-3xl font-extrabold text-azul dark:text-nuvem mt-2">
                Panggung Validasi Ide Aktif
            </h2>
            <p class="text-xs md:text-sm text-azul/70 dark:text-slate-400 mt-1 max-w-2xl">
                Eksplorasi ide-ide inovasi yang sedang divalidasi oleh komunitas. Berikan penilaian Anda untuk membantu inisiator menyempurnakan solusi mereka.
            </p>
        </div>

        <!-- Tombol Prominen Ajukan Ide Baru untuk Pengguna Umum / Senarai KIK -->
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('ideas.create') }}" class="px-5 py-3 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul font-display font-extrabold text-xs md:text-sm hover:opacity-90 transition shadow-md flex items-center gap-2">
                <span>+</span> Buat Sesi Validasi Ide Baru
            </a>
            <a href="{{ route('survey.create') }}" class="px-4 py-3 rounded-xl white-glass text-azul dark:text-nuvem font-bold text-xs md:text-sm hover:border-azul transition">
                Isi Survei
            </a>
        </div>
    </div>

    <!-- Live Showcase Cards Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ideas as $idea)
        <div data-tilt class="white-glass p-6 rounded-3xl border border-horizonte/25 dark:border-slate-800 flex flex-col justify-between hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div>
                <!-- Baris Atas: Kode, Sasaran Target, & Status Kuadran -->
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="px-2.5 py-1 rounded-lg bg-azul text-nuvem font-mono font-bold text-xs">
                        {{ $idea['code'] }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold {{ $idea['quadrant'] === 'Prioritas Utama' ? 'bg-sol text-azul' : ($idea['quadrant'] === 'Potensi' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200' : ($idea['quadrant'] === 'Pertimbangkan' ? 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-200' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-200')) }}">
                        {{ $idea['quadrant'] }}
                    </span>
                </div>

                <h3 class="font-display font-extrabold text-base text-azul dark:text-nuvem leading-snug line-clamp-2">
                    {{ $idea['title'] }}
                </h3>

                <p class="text-xs text-azul/65 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                    {{ $idea['description'] }}
                </p>

                <!-- Target Pengguna & Masalah -->
                <div class="mt-3.5 p-3 rounded-xl bg-nuvem/70 dark:bg-slate-900/60 border border-horizonte/20 dark:border-slate-800 text-[11px] space-y-1">
                    <div class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="text-azul dark:text-sol font-bold">🎯 Target:</span>
                        <span class="truncate">{{ $idea['target_user'] }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="text-azul dark:text-sol font-bold">⚠️ Masalah:</span>
                        <span class="truncate">{{ $idea['problem_solved'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Card: Live Score & Progress Partisipasi -->
            <div class="mt-5 pt-3.5 border-t border-horizonte/20 dark:border-slate-800">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="text-slate-500 dark:text-slate-400 text-[11px]">Partisipasi Responden</span>
                    <strong class="font-mono text-azul dark:text-nuvem font-bold">{{ $idea['respondents_count'] }} Suara</strong>
                </div>

                <!-- Progress Bar Responden -->
                @php
                    $maxResp = max($totalRespondents, 1);
                    $respPct = min(round(($idea['respondents_count'] / $maxResp) * 100), 100);
                @endphp
                <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden mb-3">
                    <div class="bg-azul dark:bg-sol h-1.5 rounded-full" style="width: {{ $respPct }}%"></div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-slate-500 dark:text-slate-400">Skor:</span>
                        <span class="px-2 py-0.5 rounded-md bg-sol text-azul font-display font-black text-xs">
                            {{ $idea['total_score'] }} / 10
                        </span>
                    </div>
                    <a href="{{ route('survey.create') }}" class="text-xs font-bold text-azul dark:text-sol hover:underline">
                        Beri Nilai &rarr;
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Live Activity Feed Log -->
    @if(isset($recentActivities) && $recentActivities->count() > 0)
    <div class="white-glass p-6 rounded-3xl border border-horizonte/25 dark:border-slate-800 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-display font-bold text-sm text-azul dark:text-nuvem flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Aktivitas Terkini di IDEA LAB
            </h3>
            <span class="text-[11px] text-slate-500 dark:text-slate-400">Real-time Activity Log</span>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($recentActivities as $act)
            <div class="p-3 rounded-xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/70 dark:border-slate-800 text-xs space-y-1">
                <div class="flex items-center justify-between">
                    <strong class="font-bold text-azul dark:text-sol">{{ $act->user_name }}</strong>
                    <span class="text-[10px] text-slate-400">{{ $act->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-snug truncate">{{ $act->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</section>

<script>
// ANIMASI 3D GAYA PINTEREST CLEAN STUDIO (Glossy Porcelain, Frosted Glass Ring, Navy & Gold Spheres)
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('pinterestWhite3D');
    if (!container) return;

    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || (window.innerHeight * 0.85);

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(42, width / height, 0.1, 1000);
    camera.position.set(0, 1.2, 13.5);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    container.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.enableZoom = false; // Supaya scroll halaman tetap mulus

    // PENCAHAYAAN STUDIO TERANG (Softbox White + Warm Gold + Cool Periwinkle)
    const ambientLight = new THREE.AmbientLight(0xffffff, 1.9);
    scene.add(ambientLight);

    const mainStudioLight = new THREE.DirectionalLight(0xffffff, 2.2);
    mainStudioLight.position.set(8, 14, 10);
    mainStudioLight.castShadow = true;
    scene.add(mainStudioLight);

    const rimLightBlue = new THREE.PointLight(0x7189C6, 3, 30);
    rimLightBlue.position.set(-8, -4, 6);
    scene.add(rimLightBlue);

    const rimLightGold = new THREE.PointLight(0xFDB800, 2.5, 30);
    rimLightGold.position.set(7, 6, -5);
    scene.add(rimLightGold);

    // GRUP PATUNG 3D UTAMA DI TENGAH LAYAR
    const sculpture = new THREE.Group();
    scene.add(sculpture);

    // 1. Inti Glossy Ceramic TorusKnot (Warna Azul Brant #001B5E mengkilap seperti keramik/kaca)
    const coreGeo = new THREE.TorusKnotGeometry(1.75, 0.52, 180, 32);
    const coreMat = new THREE.MeshPhysicalMaterial({
        color: 0x001B5E,
        metalness: 0.15,
        roughness: 0.08,
        clearcoat: 1.0,
        clearcoatRoughness: 0.05
    });
    const coreMesh = new THREE.Mesh(coreGeo, coreMat);
    sculpture.add(coreMesh);

    // 2. Cincin Kaca Frosted Acrylic (Horizonte Claro #7189C6)
    const glassRingGeo = new THREE.TorusGeometry(3.2, 0.22, 32, 120);
    const glassRingMat = new THREE.MeshPhysicalMaterial({
        color: 0x7189C6,
        transparent: true,
        opacity: 0.55,
        roughness: 0.15,
        metalness: 0.1,
        clearcoat: 1.0
    });
    const glassRing = new THREE.Mesh(glassRingGeo, glassRingMat);
    glassRing.rotation.x = Math.PI / 3;
    sculpture.add(glassRing);

    // 3. Cincin Kedua Porselen Putih (Nuvem #FFFFFF)
    const whiteRingGeo = new THREE.TorusGeometry(3.8, 0.12, 24, 100);
    const whiteRingMat = new THREE.MeshPhysicalMaterial({
        color: 0xFFFFFF,
        roughness: 0.1,
        clearcoat: 1.0
    });
    const whiteRing = new THREE.Mesh(whiteRingGeo, whiteRingMat);
    whiteRing.rotation.y = Math.PI / 4;
    sculpture.add(whiteRing);

    // 4. 10 Bola Ide Mengambang (Kombinasi Emas #FDB800, Putih Porselen #FFFFFF, dan Biru #7189C6)
    const floatingOrbs = [];
    const palette = [0xFDB800, 0xFFFFFF, 0x7189C6, 0x001B5E];

    for (let i = 0; i < 10; i++) {
        const radius = i % 3 === 0 ? 0.42 : 0.28;
        const orbGeo = new THREE.SphereGeometry(radius, 32, 32);
        const orbColor = palette[i % palette.length];
        const orbMat = new THREE.MeshPhysicalMaterial({
            color: orbColor,
            roughness: 0.08,
            metalness: orbColor === 0xFDB800 ? 0.35 : 0.05,
            clearcoat: 1.0
        });
        const orb = new THREE.Mesh(orbGeo, orbMat);
        const angle = (i / 10) * Math.PI * 2;
        const dist = 3.5 + (i % 2) * 0.85;

        floatingOrbs.push({ mesh: orb, angle, dist, speed: 0.006 + i * 0.001, offset: i });
        sculpture.add(orb);
    }

    // 5. Bayangan Lembut di Bawah Objek 3D (Supaya Terasa Mengambang di Studio Putih)
    const shadowGeo = new THREE.CircleGeometry(3.4, 64);
    const shadowMat = new THREE.MeshBasicMaterial({
        color: 0x001B5E,
        transparent: true,
        opacity: 0.08
    });
    const floorShadow = new THREE.Mesh(shadowGeo, shadowMat);
    floorShadow.rotation.x = -Math.PI / 2;
    floorShadow.position.y = -4.2;
    scene.add(floorShadow);

    // Interaksi Gerakan Mouse Halus
    let targetX = 0, targetY = 0;
    window.addEventListener('mousemove', (e) => {
        targetX = (e.clientX / window.innerWidth - 0.5) * 0.9;
        targetY = (e.clientY / window.innerHeight - 0.5) * 0.6;
    });

    let clock = new THREE.Clock();
    function animate() {
        requestAnimationFrame(animate);
        const t = clock.getElapsedTime();

        // Gerakan Mengambang (Levitation)
        sculpture.position.y = Math.sin(t * 1.5) * 0.28;
        floorShadow.scale.setScalar(1 - Math.sin(t * 1.5) * 0.08);

        // Rotasi Elegan
        coreMesh.rotation.x = t * 0.25;
        coreMesh.rotation.y = t * 0.35;
        glassRing.rotation.z = -t * 0.3;
        whiteRing.rotation.x = t * 0.2;

        // Orbit 10 Bola Ide
        floatingOrbs.forEach((o) => {
            o.angle += o.speed;
            o.mesh.position.x = Math.cos(o.angle) * o.dist;
            o.mesh.position.z = Math.sin(o.angle) * o.dist;
            o.mesh.position.y = Math.sin(t * 2 + o.offset) * 1.3;
        });

        // Parallax mengikuti kursor mouse
        sculpture.rotation.y += (targetX - sculpture.rotation.y) * 0.05;
        sculpture.rotation.x += (targetY - sculpture.rotation.x) * 0.05;

        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        if (!container) return;
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    // Inisialisasi efek miring 3D pada kartu Bento
    if (window.VanillaTilt) {
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 5,
            speed: 400,
            glare: true,
            "max-glare": 0.25
        });
    }
});
</script>
@endsection
