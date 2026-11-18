<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'target_user',
        'problem_solved',
        'status',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Perhitungan Rata-rata Feasibility, Impact, Total Skor, dan Logika Kuadran
    public function getAnalysisAttribute(): array
    {
        $count = $this->ratings->count();
        $avgFeasibility = $count > 0 ? round($this->ratings->avg('feasibility'), 2) : 0.0;
        $avgImpact = $count > 0 ? round($this->ratings->avg('impact'), 2) : 0.0;
        $totalScore = round($avgFeasibility + $avgImpact, 2);

        // Logika Kuadran (Batas Nilai Ambang 4.00 sesuai Bab 5.4)
        if ($avgFeasibility >= 4.0 && $avgImpact >= 4.0) {
            $quadrant = 'Prioritas Utama';
            $color = '#FDB800'; // Sol de Minas (Kuning Emas)
            $badgeClass = 'bg-[#FDB800] text-[#001B5E]';
        } elseif ($avgFeasibility < 4.0 && $avgImpact >= 4.0) {
            $quadrant = 'Potensi';
            $color = '#7189C6'; // Horizonte Claro (Biru Muda)
            $badgeClass = 'bg-[#7189C6] text-[#F4F5F7]';
        } elseif ($avgFeasibility >= 4.0 && $avgImpact < 4.0) {
            $quadrant = 'Pertimbangkan';
            $color = '#F4F5F7'; // Nuvem (Putih Awan)
            $badgeClass = 'bg-[#F4F5F7] text-[#001B5E]';
        } else {
            $quadrant = 'Tunda';
            $color = '#ef4444'; // Merah Peringatan
            $badgeClass = 'bg-red-500/80 text-white';
        }

        return [
            'respondents_count' => $count,
            'avg_feasibility'   => $avgFeasibility,
            'avg_impact'        => $avgImpact,
            'total_score'       => $totalScore,
            'quadrant'          => $quadrant,
            'color'             => $color,
            'badge_class'       => $badgeClass,
        ];
    }
}
