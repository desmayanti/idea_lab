@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-horizonte/30 dark:border-slate-800 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-azul/10 dark:bg-horizonte/20 text-azul dark:text-nuvem text-xs font-bold uppercase tracking-wider">
                ANALITIK &amp; AUDIT RESPONDEN
            </div>
            <h1 class="font-display text-3xl font-extrabold text-azul dark:text-nuvem mt-2">Data &amp; Partisipasi Responden</h1>
            <p class="text-sm text-azul/70 dark:text-slate-400 mt-1">Audit validitas instrumen penilaian, rekap skor responden terverifikasi, dan transparansi data.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('survey.create') }}" class="px-5 py-2.5 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul font-display font-extrabold text-xs md:text-sm hover:opacity-90 transition shadow-md flex items-center gap-2">
                <span>+</span> Input Survei Baru
            </a>
            <a href="{{ route('report.pdf') }}" class="px-4 py-2.5 rounded-xl white-glass text-azul dark:text-nuvem font-bold text-xs hover:border-azul transition flex items-center gap-1.5">
                <span>📄</span> Export PDF
            </a>
        </div>
    </div>

    <!-- 1. TOP SUMMARY METRIC RIBBON (4 KPI TERUKUR) -->
    <div class="bg-white dark:bg-[#0B1736] border border-slate-200/90 dark:border-[#7189C6]/25 rounded-2xl shadow-sm overflow-hidden">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-200/80 dark:divide-[#7189C6]/20">
            <!-- Metric 1: Total Responden -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Total Responden</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-black text-azul dark:text-nuvem">{{ $totalVerified }}</p>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 font-bold">
                    <span>✓</span> Terverifikasi Anti-Duplikasi
                </div>
            </div>

            <!-- Metric 2: Tingkat Penyelesaian -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Tingkat Penyelesaian</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-black text-sol">{{ $completionRate }}</p>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Semua Ide Dinilai Penuh (10/10)
                </div>
            </div>

            <!-- Metric 3: Rata-rata Feasibility -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Rata-rata Feasibility</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-black text-azul dark:text-nuvem">
                        {{ $avgFeasibilityGiven }} <span class="text-xs text-slate-400 font-normal">/ 5.0</span>
                    </p>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Kelayakan Teknis Komunitas
                </div>
            </div>

            <!-- Metric 4: Rata-rata Impact -->
            <div class="p-5 flex flex-col justify-between">
                <span class="text-[11px] text-slate-500 dark:text-[#7189C6] uppercase font-extrabold tracking-wider">Rata-rata Impact</span>
                <div class="my-2">
                    <p class="text-3xl font-display font-black text-azul dark:text-nuvem">
                        {{ $avgImpactGiven }} <span class="text-xs text-slate-400 font-normal">/ 5.0</span>
                    </p>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    Dampak Solusi Pengguna
                </div>
            </div>
        </div>
    </div>

    <!-- 2. FILTER & PENCARIAN RESPONDEN -->
    <div class="p-4 rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-3">
        <form method="GET" action="{{ route('respondents.index') }}" class="flex flex-wrap items-center gap-2.5 flex-1">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama responden / kategori..."
                    class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul outline-none">
                <span class="absolute left-3 top-2.5 text-xs text-slate-400">🔍</span>
            </div>

            @if(isset($categories) && $categories->count() > 0)
            <select name="class" onchange="this.form.submit()"
                class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-azul dark:text-nuvem font-medium focus:border-azul outline-none">
                <option value="">Semua Kategori / Kelas</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('class') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @endif

            <button type="submit" class="px-4 py-2 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul text-xs font-bold hover:opacity-90 transition">
                Filter
            </button>

            @if(request('search') || request('class'))
            <a href="{{ route('respondents.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-200 transition">
                Reset
            </a>
            @endif
        </form>

        <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold shrink-0">
            Menampilkan <strong>{{ $responses->count() }}</strong> Responden
        </span>
    </div>

    <!-- 3. TABEL DATA RESPONDEN TERSTRUKTUR -->
    <div class="white-glass rounded-2xl border border-horizonte/25 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100/70 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 uppercase text-[11px] font-extrabold tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Nama Responden</th>
                        <th class="py-3.5 px-4">Kategori / Instansi</th>
                        <th class="py-3.5 px-4 text-center">Waktu Kirim</th>
                        <th class="py-3.5 px-4 text-center">Ide Dinilai</th>
                        <th class="py-3.5 px-4 text-center">Rata-rata Skor</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70 dark:divide-slate-800">
                    @forelse($responses as $idx => $resp)
                    @php
                        $ratingsCount = $resp->ratings ? $resp->ratings->count() : 0;
                        $avgF = $ratingsCount > 0 ? round($resp->ratings->avg('feasibility'), 2) : 0;
                        $avgI = $ratingsCount > 0 ? round($resp->ratings->avg('impact'), 2) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                        <td class="py-4 px-4 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-4 px-4 font-bold text-azul dark:text-nuvem">
                            <div class="flex items-center gap-2.5">
                                <span class="w-7 h-7 rounded-lg bg-azul/10 dark:bg-slate-800 text-azul dark:text-sol flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($resp->respondent_name, 0, 1) }}
                                </span>
                                <div>
                                    <span class="block">{{ $resp->respondent_name }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal">ID: #RESP-{{ str_pad($resp->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-600 dark:text-slate-300 font-medium">
                            <span class="px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold">
                                {{ $resp->respondent_class }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                            {{ $resp->submitted_at ? $resp->submitted_at->format('d/m/Y H:i') : ($resp->created_at ? $resp->created_at->format('d/m/Y H:i') : '-') }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-extrabold {{ $ratingsCount >= 10 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300' : 'bg-amber-100 text-amber-800' }}">
                                <span>{{ $ratingsCount }}/10 Ide</span>
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center font-mono text-xs">
                            <span class="text-emerald-700 dark:text-emerald-400 font-bold" title="Rata-rata Feasibility">F: {{ $avgF }}</span>
                            <span class="text-slate-400 mx-1">•</span>
                            <span class="text-amber-600 dark:text-amber-400 font-bold" title="Rata-rata Impact">I: {{ $avgI }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800 text-[11px] font-bold">
                                ✓ Terverifikasi
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" onclick="openDetailModal({{ $resp->id }})"
                                    class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-azul dark:text-sol hover:bg-azul hover:text-white dark:hover:bg-sol dark:hover:text-azul transition shadow-sm">
                                    Detail
                                </button>
                                <form action="{{ route('respondents.destroy', $resp->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data responden {{ $resp->respondent_name }}? Data penilaian terkait akan dihapus dan kuadran dikalkulasi ulang.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Responden"
                                        class="w-7 h-7 rounded-lg bg-white dark:bg-slate-800 border border-rose-200 dark:border-rose-900/60 text-rose-500 hover:bg-rose-500 hover:text-white transition flex items-center justify-center text-xs">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada data responden yang sesuai dengan kriteria pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL DETAIL JAWABAN RESPONDEN -->
<div id="respondentDetailModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <!-- Header Modal -->
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 id="modalRespondentName" class="font-display font-extrabold text-lg text-azul dark:text-nuvem">
                    Detail Penilaian Responden
                </h3>
                <p id="modalRespondentMeta" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Memuat data...
                </p>
            </div>
            <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 flex items-center justify-center font-bold text-sm">
                ✕
            </button>
        </div>

        <!-- Body Modal (Daftar Rating Tiap Ide) -->
        <div id="modalRatingsList" class="p-5 overflow-y-auto space-y-3 divide-y divide-slate-100 dark:divide-slate-800 text-xs">
            <!-- Diisi lewat JavaScript -->
        </div>

        <!-- Footer Modal -->
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex justify-end">
            <button type="button" onclick="closeDetailModal()" class="px-5 py-2 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul font-bold text-xs hover:opacity-90 transition">
                Tutup Rincian
            </button>
        </div>
    </div>
</div>

<!-- Data JSON Responden untuk Modal Interaktif -->
<script>
const responsesData = @json($responses);

function openDetailModal(respId) {
    const resp = responsesData.find(r => r.id === respId);
    if (!resp) return;

    document.getElementById('modalRespondentName').textContent = resp.respondent_name;
    document.getElementById('modalRespondentMeta').textContent = `Kategori: ${resp.respondent_class} • Waktu: ${resp.submitted_at || resp.created_at || '-'}`;

    const list = document.getElementById('modalRatingsList');
    list.innerHTML = '';

    if (resp.ratings && resp.ratings.length > 0) {
        resp.ratings.forEach(rating => {
            const item = document.createElement('div');
            item.className = 'pt-3 first:pt-0';
            item.innerHTML = `
                <div class="flex items-center justify-between gap-2 mb-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-slate-100 dark:bg-slate-800 text-azul dark:text-sol">${rating.idea ? rating.idea.code : '-'}</span>
                        <strong class="text-azul dark:text-nuvem font-bold">${rating.idea ? rating.idea.title : 'Ide'}</strong>
                    </div>
                    <div class="flex items-center gap-2 font-mono text-[11px]">
                        <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 font-bold">F: ${rating.feasibility}</span>
                        <span class="px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 font-bold">I: ${rating.impact}</span>
                    </div>
                </div>
                ${rating.comment ? `<p class="text-[11px] text-slate-500 dark:text-slate-400 italic bg-slate-50 dark:bg-slate-900/60 p-2 rounded-lg mt-1">💬 "${rating.comment}"</p>` : ''}
            `;
            list.appendChild(item);
        });
    } else {
        list.innerHTML = '<p class="text-center text-slate-400 py-4">Belum ada rincian penilaian untuk responden ini.</p>';
    }

    document.getElementById('respondentDetailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('respondentDetailModal').classList.add('hidden');
}

// Tutup modal jika klik di luar area konten
window.addEventListener('click', (e) => {
    const modal = document.getElementById('respondentDetailModal');
    if (e.target === modal) {
        closeDetailModal();
    }
});
</script>
@endsection
