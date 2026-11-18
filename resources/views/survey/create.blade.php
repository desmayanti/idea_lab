@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12 space-y-8">

    <!-- Header Formulir Bersih & Terfokus -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-horizonte/30 dark:border-slate-700 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-azul/10 dark:bg-horizonte/20 text-azul dark:text-nuvem text-xs font-black uppercase tracking-wider">
                INSTRUMEN VALIDASI IDE
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-azul dark:text-nuvem mt-2">Form Penilaian Ide Solusi Digital</h1>
            <p class="text-azul/75 dark:text-slate-300 text-sm mt-1">
                Berikan skor 1 (Sangat Rendah) hingga 5 (Sangat Tinggi) secara independen dan objektif pada aspek <strong class="text-azul dark:text-nuvem font-bold">Feasibility</strong> (Kelayakan Teknis) dan <strong class="text-sol font-bold">Impact</strong> (Dampak Solusi).
            </p>
        </div>

        <!-- Sticky Floating Progress Indicator -->
        <div class="white-glass p-4 rounded-2xl border border-horizonte/30 dark:border-slate-700 shrink-0 min-w-55">
            <div class="flex justify-between items-center text-xs font-bold mb-1.5">
                <span class="text-azul/70 dark:text-slate-300">Kemajuan Penilaian</span>
                <span id="progressText" class="text-azul dark:text-sol font-display font-black">0 / {{ count($ideas) }} Ide Dinilai</span>
            </div>
            <div class="w-full bg-nuvem dark:bg-slate-800 rounded-full h-2.5 overflow-hidden border border-horizonte/20 dark:border-slate-700">
                <div id="progressBar" class="bg-azul dark:bg-sol h-2.5 rounded-full transition-all duration-300 w-0"></div>
            </div>
        </div>
    </div>

    <!-- Error Validasi & Anti-Duplikasi -->
    @if($errors->any())
    <div class="p-5 rounded-2xl bg-red-500/10 border-2 border-red-500 text-red-700 dark:text-red-300 text-sm space-y-2">
        <div class="flex items-center gap-2 font-bold text-red-800 dark:text-red-200">
            <span>⚠️</span> Terdapat kendala pada pengisian formulir:
        </div>
        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-300 pl-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('survey.store') }}" method="POST" id="surveyForm" class="space-y-8">
        @csrf

        <!-- Bagian 1: Identitas Responden (Terbuka untuk Umum / KIK / UMKM) -->
        <div class="white-glass p-6 sm:p-8 rounded-4xl border border-horizonte/25 dark:border-slate-700 space-y-4 shadow-sm">
            <h3 class="font-display text-lg font-bold text-azul dark:text-nuvem flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-azul dark:bg-sol text-nuvem dark:text-azul flex items-center justify-center text-xs font-black">1</span>
                Identitas Responden
            </h3>

            <div class="grid md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Nama Lengkap Responden *</label>
                    <input type="text" name="respondent_name" value="{{ old('respondent_name') }}" required
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-3.5 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-horizonte/50 dark:placeholder-slate-500 focus:border-azul dark:focus:border-sol focus:ring-1 focus:ring-azul outline-none transition shadow-sm">
                    <p class="text-[11px] text-azul/60 dark:text-slate-400 mt-1.5 font-medium">Satu nama responden hanya dapat mengirimkan survei 1 kali (anti-duplikasi).</p>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Kategori / Instansi / Peran Responden *</label>
                    <input type="text" name="respondent_class" value="{{ old('respondent_class') }}" required
                        placeholder="Contoh: Pelaku UMKM / Mahasiswa / Masyarakat Umum"
                        class="w-full px-4 py-3.5 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-horizonte/50 dark:placeholder-slate-500 focus:border-azul dark:focus:border-sol focus:ring-1 focus:ring-azul outline-none transition shadow-sm">
                    <p class="text-[11px] text-azul/60 dark:text-slate-400 mt-1.5 font-medium">Terbuka untuk umum, komunitas, UMKM, dan mitra.</p>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Penilaian Murni Tanpa Bocoran Skor / Kuadran -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="font-display text-lg font-bold text-azul dark:text-nuvem flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-azul dark:bg-sol text-nuvem dark:text-azul flex items-center justify-center text-xs font-black">2</span>
                    Lembar Penilaian Ide Solusi
                </h3>
                <span class="text-xs text-azul/65 dark:text-slate-400 font-bold">Skala 1 (Sangat Rendah) &bull; 5 (Sangat Tinggi)</span>
            </div>

            @foreach($ideas as $index => $idea)
            <div class="idea-card white-glass p-6 sm:p-7 rounded-[28px] border border-horizonte/25 dark:border-slate-700 space-y-5 hover:border-azul/50 dark:hover:border-sol/50 transition-all duration-300">
                <!-- Info Ide Header (Tanpa Ranking / Skor Sebelumnya) -->
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-horizonte/20 dark:border-slate-700/60 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-azul text-nuvem font-display font-extrabold text-xs">
                                {{ $idea->code }}
                            </span>
                            <span class="text-xs text-azul/60 dark:text-slate-400 font-semibold">Ide Ke-{{ $index + 1 }} dari {{ count($ideas) }}</span>
                        </div>
                        <h4 class="text-lg md:text-xl font-bold text-azul dark:text-nuvem mt-1.5">{{ $idea->title }}</h4>
                    </div>

                    <div class="flex flex-col items-end">
                        <span class="text-[10px] text-azul/50 dark:text-slate-400 uppercase font-bold">Sasaran Target:</span>
                        <span class="px-3 py-1 rounded-full bg-nuvem dark:bg-slate-800 border border-horizonte/30 dark:border-slate-700 text-azul dark:text-nuvem text-xs font-bold mt-0.5">
                            {{ $idea->target_user }}
                        </span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 text-xs text-azul/75 dark:text-slate-300 bg-nuvem/70 dark:bg-slate-900/60 p-4 rounded-2xl border border-horizonte/20 dark:border-slate-700/60">
                    <div>
                        <span class="text-azul dark:text-nuvem font-bold block mb-0.5">Masalah yang Diatasi:</span>
                        <p class="leading-relaxed">{{ $idea->problem_solved }}</p>
                    </div>
                    <div>
                        <span class="text-azul dark:text-nuvem font-bold block mb-0.5">Deskripsi Solusi:</span>
                        <p class="leading-relaxed">{{ $idea->description }}</p>
                    </div>
                </div>

                <!-- Input Feasibility & Impact 1-5 (Unbiased Tanpa Checked Default) -->
                <div class="grid md:grid-cols-2 gap-6 pt-2">
                    <!-- 1. Feasibility (Kelayakan Teknis) -->
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-horizonte/30 dark:border-slate-700 space-y-2.5 shadow-sm">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold uppercase text-azul dark:text-nuvem">
                                A. Feasibility (Kelayakan Teknis) *
                            </label>
                            <span class="text-[10px] text-azul/50 dark:text-slate-400">1 = Sulit &bull; 5 = Sangat Mudah</span>
                        </div>
                        <div class="grid grid-cols-5 gap-2">
                            @for($s = 1; $s <= 5; $s++)
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="ratings[{{ $idea->id }}][feasibility]" value="{{ $s }}"
                                    class="rating-input peer sr-only" required
                                    {{ old("ratings.{$idea->id}.feasibility") == $s ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-xl border border-horizonte/30 dark:border-slate-700 text-azul/70 dark:text-slate-300 font-display font-bold text-sm bg-nuvem/50 dark:bg-slate-800 peer-checked:bg-azul dark:peer-checked:bg-sol peer-checked:text-nuvem dark:peer-checked:text-azul peer-checked:border-azul dark:peer-checked:border-sol peer-checked:shadow-md transition-all duration-200 hover:border-azul/50">
                                    {{ $s }}
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <!-- 2. Impact (Dampak Solusi) -->
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-horizonte/30 dark:border-slate-700 space-y-2.5 shadow-sm">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold uppercase text-azul dark:text-nuvem">
                                B. Impact (Dampak Solusi) *
                            </label>
                            <span class="text-[10px] text-azul/50 dark:text-slate-400">1 = Rendah &bull; 5 = Sangat Berdampak</span>
                        </div>
                        <div class="grid grid-cols-5 gap-2">
                            @for($s = 1; $s <= 5; $s++)
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="ratings[{{ $idea->id }}][impact]" value="{{ $s }}"
                                    class="rating-input peer sr-only" required
                                    {{ old("ratings.{$idea->id}.impact") == $s ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-xl border border-horizonte/30 dark:border-slate-700 text-azul/70 dark:text-slate-300 font-display font-bold text-sm bg-nuvem/50 dark:bg-slate-800 peer-checked:bg-sol peer-checked:text-azul peer-checked:border-sol peer-checked:shadow-md transition-all duration-200 hover:border-sol">
                                    {{ $s }}
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Input Komentar / Alasan Penilaian Opsional -->
                <div>
                    <input type="text" name="ratings[{{ $idea->id }}][comment]"
                        value="{{ old("ratings.{$idea->id}.comment") }}"
                        placeholder="Catatan / masukan konstruktif untuk {{ $idea->code }} (opsional)..."
                        class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/30 dark:border-slate-700 text-xs text-azul dark:text-nuvem placeholder-horizonte/50 dark:placeholder-slate-500 focus:border-azul dark:focus:border-sol outline-none transition shadow-sm">
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tombol Aksi Submit -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="text-xs text-azul/60 dark:text-slate-400 hover:text-azul dark:hover:text-sol transition font-semibold">
                &larr; Batalkan dan Kembali ke Dashboard
            </a>
            <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-full bg-azul dark:bg-sol text-nuvem dark:text-azul font-display font-extrabold text-base hover:bg-azul/90 dark:hover:bg-sol/90 active:scale-95 transition-all duration-200 shadow-xl">
                Kirim &amp; Kalkulasi Kuadran Otomatis &rarr;
            </button>
        </div>
    </form>

</div>

<!-- Skrip Interaktif: Dynamic Form Progress Tracker -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const totalIdeas = {{ count($ideas) }};
    const radioInputs = document.querySelectorAll('.rating-input');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    function updateProgress() {
        let answeredIdeas = 0;
        const ideaCards = document.querySelectorAll('.idea-card');

        ideaCards.forEach((card) => {
            const fChecked = card.querySelector('input[name*="[feasibility]"]:checked');
            const iChecked = card.querySelector('input[name*="[impact]"]:checked');
            if (fChecked && iChecked) {
                answeredIdeas++;
            }
        });

        const percent = Math.round((answeredIdeas / totalIdeas) * 100);
        if (progressBar) progressBar.style.width = percent + '%';
        if (progressText) progressText.innerText = `${answeredIdeas} / ${totalIdeas} Ide Dinilai (${percent}%)`;
    }

    radioInputs.forEach(input => {
        input.addEventListener('change', updateProgress);
    });

    updateProgress();
});
</script>
@endsection
