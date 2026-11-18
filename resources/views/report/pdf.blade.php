<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Validasi IDEA LAB</title>
    <style>
        body { font-family: sans-serif; color: #001B5E; font-size: 12px; line-height: 1.5; }
        .header { border-bottom: 3px solid #001B5E; padding-bottom: 10px; margin-bottom: 18px; }
        .header h1 { margin: 0; font-size: 20px; color: #001B5E; }
        .header p { margin: 3px 0 0; color: #555; font-size: 11px; }
        .winner-box { background-color: #F4F5F7; border-left: 5px solid #FDB800; padding: 12px 15px; margin-bottom: 20px; }
        .winner-box h3 { margin: 0 0 5px; color: #001B5E; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #001B5E; color: #FFFFFF; padding: 8px; text-align: left; font-size: 11px; }
        td { border-bottom: 1px solid #DDD; padding: 7px 8px; font-size: 11px; }
        .text-center { text-align: center; }
        .badge-top { background-color: #FDB800; color: #001B5E; font-weight: bold; padding: 2px 6px; border-radius: 4px; }
        .footer { margin-top: 25px; font-size: 10px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN HASIL VALIDASI IDE — IDEA LAB</h1>
        <p>Studi Kasus Solusi Digital E-Commerce KYOTO STORE • Tahun 2026/2027</p>
    </div>

    @if($topIdea)
    <div class="winner-box">
        <h3>REKOMENDASI IDE TERPILIH (PERINGKAT #1): {{ $topIdea['code'] }} — {{ $topIdea['title'] }}</h3>
        <p style="margin:0;">
            Berdasarkan survei dari <strong>{{ $totalRespondents }} responden</strong>, ide ini memperoleh rata-rata Feasibility <strong>{{ $topIdea['avg_feasibility'] }}/5</strong>, rata-rata Impact <strong>{{ $topIdea['avg_impact'] }}/5</strong>, dan Total Skor tertinggi <strong>{{ $topIdea['total_score'] }}/10</strong> (Kategori Kuadran: <strong>{{ $topIdea['quadrant'] }}</strong>).
        </p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th class="text-center">Rank</th>
                <th>Kode</th>
                <th>Nama Ide Solusi Digital</th>
                <th>Target</th>
                <th class="text-center">Feasibility</th>
                <th class="text-center">Impact</th>
                <th class="text-center">Total Skor</th>
                <th class="text-center">Kuadran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankedIdeas as $idx => $idea)
            <tr>
                <td class="text-center"><strong>#{{ $idx + 1 }}</strong></td>
                <td><strong>{{ $idea['code'] }}</strong></td>
                <td>{{ $idea['title'] }}</td>
                <td>{{ $idea['target_user'] }}</td>
                <td class="text-center">{{ $idea['avg_feasibility'] }}</td>
                <td class="text-center">{{ $idea['avg_impact'] }}</td>
                <td class="text-center"><strong>{{ $idea['total_score'] }}</strong></td>
                <td class="text-center">
                    <span class="{{ $idea['quadrant'] === 'Prioritas Utama' ? 'badge-top' : '' }}">
                        {{ $idea['quadrant'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem IDEA LAB • Test Ideas. Analyze Data. Build Better.
    </div>
</body>
</html>
