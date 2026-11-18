<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Rating;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        [$ideas, $rankedIdeas, $isTie] = DashboardController::getAnalyzedIdeas();
        $topIdea = $rankedIdeas->first();
        $totalRespondents = Rating::distinct('respondent_name')->count('respondent_name');
        $totalRatings = Rating::count();
        $globalFeasibility = $ideas->count() > 0 ? round($ideas->avg('avg_feasibility'), 2) : 0;
        $globalImpact = $ideas->count() > 0 ? round($ideas->avg('avg_impact'), 2) : 0;

        return view('report.index', compact(
            'ideas',
            'rankedIdeas',
            'topIdea',
            'isTie',
            'totalRespondents',
            'totalRatings',
            'globalFeasibility',
            'globalImpact'
        ));
    }

    public function exportCsv(): StreamedResponse
    {
        [$ideas, $rankedIdeas] = DashboardController::getAnalyzedIdeas();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="IDEA_LAB_Laporan_Validasi_' . date('Ymd_His') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rankedIdeas) {
            $handle = fopen('php://output', 'w');
            // Tambahkan BOM agar karakter terbaca rapi di Excel Windows
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Peringkat',
                'Kode Ide',
                'Nama Ide Solusi',
                'Sasaran Target',
                'Jumlah Responden',
                'Rata-rata Feasibility (Kelayakan)',
                'Rata-rata Impact (Dampak)',
                'Total Skor (Feasibility + Impact)',
                'Kategori Kuadran',
            ]);

            foreach ($rankedIdeas as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item['code'],
                    $item['title'],
                    $item['target_user'],
                    $item['respondents_count'],
                    number_format($item['avg_feasibility'], 2),
                    number_format($item['avg_impact'], 2),
                    number_format($item['total_score'], 2),
                    $item['quadrant'],
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
