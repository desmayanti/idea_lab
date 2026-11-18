@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 space-y-8">

    <!-- Header Laporan & Tombol Cetak / Export -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-horizonte/30 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-azul/10 text-azul text-xs font-bold uppercase tracking-wider">
                BAB 4.10 • LAPORAN AKHIR VALIDASI
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-azul mt-2">
                Laporan Hasil Validasi 10 Solusi Digital
            </h1>
            <p class="text-sm text-azul/70 mt-1">
                Studi Kasus Solusi Digital E-Commerce <strong class="text-azul">KYOTO STORE</strong>
            </p>
        </div>

        <div class="no-print flex flex-wrap gap-3">
            <a href="{{ route('report.export.csv') }}" class="px-5 py-3 rounded-full bg-white border border-horizonte/40 text-azul font-bold text-xs hover:border-azul transition flex items-center gap-2 shadow-sm">
                <span>📥</span> Unduh Format CSV
            </a>
            <button onclick="window.print()" class="px-6 py-3 rounded-full bg-sol text-azul font-display font-black text-sm hover:brightness-105 active:scale-95 transition flex items-center gap-2 shadow-md">
                <span>🖨️</span> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Ringkasan Eksekutif & Ide Prioritas Terpilih -->
    @if($topIdea)
    <div class="white-glass-gold p-7 rounded-[32px] space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs uppercase tracking-widest font-black text-azul flex items-center gap-1.5">
                <span>🏆</span> KESIMPULAN REKOMENDASI SISTEM: IDE PRIORITAS TERPILIH
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-black bg-azul text-nuvem">
                {{ $topIdea['quadrant'] }}
            </span>
        </div>
        <h2 class="text-2xl md:text-3xl font-display font-extrabold text-azul">
            {{ $topIdea['code'] }} — {{ $topIdea['title'] }}
        </h2>
        <p class="text-sm text-azul/75 leading-relaxed">
            Berdasarkan agregasi dan kalkulasi data survei dari <strong>{{ $totalRespondents }} responden</strong> (total <strong>{{ $totalRatings }} penilaian</strong>), solusi digital terbaik yang direkomendasikan untuk segera diimplementasikan pada tahap produksi adalah <strong>{{ $topIdea['code'] }} ({{ $topIdea['title'] }})</strong> dengan rata-rata <strong class="text-azul">Feasibility {{ $topIdea['avg_feasibility'] }} / 5.0</strong>, rata-rata <strong class="text-azul">Impact {{ $topIdea['avg_impact'] }} / 5.0</strong>, dan akumulasi <strong class="text-azul">Total Skor {{ $topIdea['total_score'] }} / 10.0</strong>.
        </p>
        <div class="pt-2 flex flex-wrap gap-6 text-xs text-azul/70 border-t border-horizonte/20 font-medium">
            <span>Sasaran Utama: <strong class="text-azul">{{ $topIdea['target_user'] }}</strong></span>
            <span>Rata-rata Kelayakan Global: <strong class="text-azul">{{ $globalFeasibility }}</strong></span>
            <span>Rata-rata Dampak Global: <strong class="text-azul">{{ $globalImpact }}</strong></span>
        </div>
    </div>
    @endif

    <!-- Dua Grafik Wajib Sesuai Poin Penilaian: Matriks 2D & Total Skor (Light Mode) -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- 1. Grafik Matriks Feasibility vs Impact -->
        <div class="white-glass p-6 rounded-[28px] border border-horizonte/25">
            <div class="mb-3">
                <span class="text-[11px] font-bold uppercase text-horizonte">GRAFIK 1 • PEMETAAN KUADRAN</span>
                <h3 class="text-base font-bold text-azul">Matriks Feasibility vs Impact (Batas Ambang 4.00)</h3>
            </div>
            <div class="bg-white p-3 rounded-2xl border border-horizonte/20 shadow-inner">
                <canvas id="reportMatrixChart" height="230"></canvas>
            </div>
        </div>

        <!-- 2. Grafik Total Skor 10 Ide -->
        <div class="white-glass p-6 rounded-[28px] border border-horizonte/25">
            <div class="mb-3">
                <span class="text-[11px] font-bold uppercase text-horizonte">GRAFIK 2 • SKOR KOMPARATIF</span>
                <h3 class="text-base font-bold text-azul">Perbandingan Total Skor 10 Ide (Skala 10.0)</h3>
            </div>
            <div class="bg-white p-3 rounded-2xl border border-horizonte/20 shadow-inner">
                <canvas id="reportScoreChart" height="230"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi Lengkap Seluruh Ide -->
    <div class="white-glass p-6 rounded-[28px] border border-horizonte/25 overflow-x-auto">
        <h3 class="font-display text-lg font-bold text-azul mb-4">
            Tabel Rekapitulasi Skor &amp; Pemetaan Kuadran Lengkap
        </h3>
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="border-b border-horizonte/30 text-horizonte uppercase text-xs">
                    <th class="py-2.5 px-3">Rank</th>
                    <th class="py-2.5 px-3">Kode</th>
                    <th class="py-2.5 px-3">Nama Ide Solusi</th>
                    <th class="py-2.5 px-3">Sasaran Target</th>
                    <th class="py-2.5 px-3 text-center">Responden</th>
                    <th class="py-2.5 px-3 text-center">Feasibility</th>
                    <th class="py-2.5 px-3 text-center">Impact</th>
                    <th class="py-2.5 px-3 text-center">Total Skor</th>
                    <th class="py-2.5 px-3 text-center">Kuadran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-horizonte/15">
                @foreach($rankedIdeas as $idx => $idea)
                <tr class="{{ $idx === 0 ? 'bg-sol/10 font-bold' : '' }}">
                    <td class="py-3 px-3 font-display font-bold {{ $idx === 0 ? 'text-sol' : 'text-azul' }}">
                        #{{ $idx + 1 }}
                    </td>
                    <td class="py-3 px-3 font-mono text-xs font-bold text-azul">{{ $idea['code'] }}</td>
                    <td class="py-3 px-3 font-semibold text-azul">{{ $idea['title'] }}</td>
                    <td class="py-3 px-3 text-xs text-azul/60 font-semibold">{{ $idea['target_user'] }}</td>
                    <td class="py-3 px-3 text-center text-azul/70 font-semibold">{{ $idea['respondents_count'] }}</td>
                    <td class="py-3 px-3 text-center font-semibold text-azul">{{ $idea['avg_feasibility'] }}</td>
                    <td class="py-3 px-3 text-center font-semibold text-azul">{{ $idea['avg_impact'] }}</td>
                    <td class="py-3 px-3 text-center font-display font-extrabold text-azul">{{ $idea['total_score'] }}</td>
                    <td class="py-3 px-3 text-center">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $idea['quadrant'] === 'Prioritas Utama' ? 'bg-sol text-azul' : ($idea['quadrant'] === 'Potensi' ? 'bg-horizonte text-white' : ($idea['quadrant'] === 'Pertimbangkan' ? 'bg-azul text-white' : 'bg-red-500 text-white')) }}">
                            {{ $idea['quadrant'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Lembar Pengesahan / Tanda Tangan Tim & Pengampu (Sangat Rapi untuk Cetak / PDF) -->
    <div class="white-glass p-8 rounded-[28px] border border-horizonte/25 pt-8 mt-6">
        <div class="grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-azul/60">Mengetahui,</p>
                <p class="font-bold text-azul mt-1">Guru Pengampu Mata Pelajaran KIK</p>
                <div class="h-20"></div>
                <p class="font-bold text-azul border-t border-horizonte/40 pt-2 inline-block min-w-[200px]">
                    (......................................................)
                </p>
                <p class="text-azul/50 text-[10px] mt-0.5">NIP. -</p>
            </div>
            <div>
                <p class="text-azul/60">Bandung, {{ date('d F Y') }}</p>
                <p class="font-bold text-azul mt-1">Ketua Tim Pengembang Produk</p>
                <div class="h-20"></div>
                <p class="font-bold text-azul border-t border-horizonte/40 pt-2 inline-block min-w-[200px]">
                    Billy Tristan Pradipta
                </p>
                <p class="text-azul/50 text-[10px] mt-0.5">Lead Developer &bull; KYOTO STORE</p>
            </div>
        </div>
    </div>

</div>

<!-- Skrip Render Grafik Khusus Halaman Laporan (Light Theme) -->
<script>
const reportIdeas = @json($ideas);
const reportRanked = @json($rankedIdeas);

function getReportColor(quadrant) {
    if (quadrant === 'Prioritas Utama') return '#FDB800';
    if (quadrant === 'Potensi') return '#7189C6';
    if (quadrant === 'Pertimbangkan') return '#001B5E';
    return '#EF4444';
}

// 1. Grafik Matriks Laporan (Scatter)
new Chart(document.getElementById('reportMatrixChart'), {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'Ide Solusi',
            data: reportIdeas.map(i => ({ x: i.avg_feasibility, y: i.avg_impact, code: i.code })),
            backgroundColor: reportIdeas.map(i => getReportColor(i.quadrant)),
            borderColor: '#FFFFFF',
            borderWidth: 1.5,
            pointRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                min: 1, max: 5.2,
                title: { display: true, text: 'Feasibility', color: '#001B5E' },
                ticks: { color: '#001B5E' },
                grid: { color: 'rgba(0, 27, 94, 0.08)' }
            },
            y: {
                min: 1, max: 5.2,
                title: { display: true, text: 'Impact', color: '#001B5E' },
                ticks: { color: '#001B5E' },
                grid: { color: 'rgba(0, 27, 94, 0.08)' }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

// 2. Grafik Total Skor Laporan (Bar)
new Chart(document.getElementById('reportScoreChart'), {
    type: 'bar',
    data: {
        labels: reportRanked.map(i => i.code),
        datasets: [{
            label: 'Total Skor',
            data: reportRanked.map(i => i.total_score),
            backgroundColor: reportRanked.map((i, idx) => idx === 0 ? '#FDB800' : '#7189C6'),
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { ticks: { color: '#001B5E', font: { weight: 'bold' } }, grid: { display: false } },
            y: { min: 0, max: 10, ticks: { color: '#001B5E' }, grid: { color: 'rgba(0, 27, 94, 0.08)' } }
        },
        plugins: {
            legend: { labels: { color: '#001B5E' } }
        }
    }
});
</script>
@endsection
