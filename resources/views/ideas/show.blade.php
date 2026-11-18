@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 space-y-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-horizonte/30 pb-6">
        <div>
            <a href="{{ route('ideas.index') }}" class="text-xs text-azul/60 hover:text-azul transition font-semibold">
                &larr; Kembali ke Daftar Ide
            </a>
            <div class="flex items-center gap-3 mt-2">
                <span class="px-3.5 py-1 rounded-full bg-azul text-nuvem font-display font-extrabold text-xs">
                    {{ $idea->code }}
                </span>
                <span class="px-3.5 py-1 rounded-full text-xs font-black {{ $analysis['quadrant'] === 'Prioritas Utama' ? 'bg-sol text-azul' : ($analysis['quadrant'] === 'Potensi' ? 'bg-horizonte text-white' : ($analysis['quadrant'] === 'Pertimbangkan' ? 'bg-azul text-white' : 'bg-red-500 text-white')) }}">
                    Kuadran: {{ $analysis['quadrant'] }}
                </span>
            </div>
            <h1 class="font-display text-3xl font-extrabold text-azul mt-2">{{ $idea->title }}</h1>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('ideas.edit', $idea->id) }}" class="px-5 py-2.5 rounded-full bg-white border border-horizonte/40 text-azul hover:border-azul text-xs font-bold transition shadow-sm">
                ✏️ Edit Ide
            </a>
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full bg-azul text-nuvem font-bold text-xs hover:bg-azul/90 transition shadow-md">
                Lihat di Matriks
            </a>
        </div>
    </div>

    <!-- Skor Kuadran & KPI Ide -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="white-glass p-5 rounded-[24px] border border-horizonte/25">
            <span class="text-[11px] text-horizonte uppercase font-bold block">Jumlah Responden</span>
            <strong class="text-3xl font-display font-extrabold text-azul mt-1 block">{{ $analysis['respondents_count'] }}</strong>
            <span class="text-[10px] text-azul/60">Responden Terverifikasi</span>
        </div>
        <div class="white-glass p-5 rounded-[24px] border border-horizonte/25">
            <span class="text-[11px] text-horizonte uppercase font-bold block">Rata-rata Feasibility</span>
            <strong class="text-3xl font-display font-extrabold text-azul mt-1 block">{{ $analysis['avg_feasibility'] }}</strong>
            <span class="text-[10px] text-azul/60">Skala 1.0 - 5.0</span>
        </div>
        <div class="white-glass p-5 rounded-[24px] border border-horizonte/25">
            <span class="text-[11px] text-horizonte uppercase font-bold block">Rata-rata Impact</span>
            <strong class="text-3xl font-display font-extrabold text-azul mt-1 block">{{ $analysis['avg_impact'] }}</strong>
            <span class="text-[10px] text-azul/60">Skala 1.0 - 5.0</span>
        </div>
        <div class="white-glass-gold p-5 rounded-[24px]">
            <span class="text-[11px] text-azul uppercase font-black block">Total Skor Solusi</span>
            <strong class="text-3xl font-display font-black text-azul mt-1 block">{{ $analysis['total_score'] }}</strong>
            <span class="text-[10px] text-azul/70 font-semibold">Maks 10.0</span>
        </div>
    </div>

    <!-- Detail Informasi Ide -->
    <div class="white-glass p-6 rounded-[28px] border border-horizonte/25 space-y-4">
        <h3 class="font-display text-lg font-bold text-azul">Deskripsi Solusi &amp; Masalah yang Diatasi</h3>
        <div class="grid md:grid-cols-2 gap-6 text-sm text-azul/75 pt-1">
            <div class="p-5 rounded-2xl bg-nuvem/70 border border-horizonte/20 space-y-1">
                <span class="text-azul font-black text-xs uppercase block">Sasaran Pengguna</span>
                <p class="text-azul font-bold">{{ $idea->target_user }}</p>
                <span class="text-azul font-black text-xs uppercase block pt-3">Masalah yang Diatasi</span>
                <p class="leading-relaxed">{{ $idea->problem_solved }}</p>
            </div>
            <div class="p-5 rounded-2xl bg-nuvem/70 border border-horizonte/20 space-y-1">
                <span class="text-azul font-black text-xs uppercase block">Deskripsi Lengkap Solusi</span>
                <p class="leading-relaxed">{{ $idea->description }}</p>
            </div>
        </div>
    </div>

    <!-- Riwayat Penilaian Responden -->
    <div class="white-glass p-6 rounded-[28px] border border-horizonte/25 space-y-4">
        <h3 class="font-display text-lg font-bold text-azul">
            Riwayat Penilaian &amp; Komentar Responden ({{ $idea->ratings->count() }})
        </h3>

        <div class="space-y-3">
            @forelse($idea->ratings as $rating)
            <div class="p-4 rounded-2xl bg-white border border-horizonte/20 flex flex-col sm:flex-row justify-between sm:items-center gap-3 shadow-sm">
                <div>
                    <div class="flex items-center gap-2">
                        <strong class="text-azul text-sm">{{ $rating->respondent_name }}</strong>
                        <span class="text-[11px] text-azul/60">({{ $rating->respondent_class }})</span>
                    </div>
                    @if($rating->comment)
                    <p class="text-xs text-azul/70 mt-1 italic leading-relaxed">"{{ $rating->comment }}"</p>
                    @endif
                </div>
                <div class="flex items-center gap-4 text-xs shrink-0 font-medium">
                    <span class="text-azul/70">F: <strong class="text-azul font-bold">{{ $rating->feasibility }}</strong>/5</span>
                    <span class="text-azul/70">I: <strong class="text-sol font-black">{{ $rating->impact }}</strong>/5</span>
                    <span class="text-[11px] text-azul/40">{{ $rating->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            @empty
            <p class="text-sm text-azul/60 py-4">Belum ada penilaian dari responden untuk ide ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
