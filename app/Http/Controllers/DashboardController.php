<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Rating;
use App\Models\SurveyResponse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public static function getAnalyzedIdeas()
    {
        $ideas = Idea::with('ratings')->get()->map(function ($idea) {
            $analysis = $idea->analysis;
            return [
                'id'                => $idea->id,
                'code'              => $idea->code,
                'title'             => $idea->title,
                'description'       => $idea->description,
                'target_user'       => $idea->target_user,
                'problem_solved'    => $idea->problem_solved,
                'status'            => $idea->status,
                'respondents_count' => $analysis['respondents_count'],
                'avg_feasibility'   => $analysis['avg_feasibility'],
                'avg_impact'        => $analysis['avg_impact'],
                'total_score'       => $analysis['total_score'],
                'quadrant'          => $analysis['quadrant'],
                'color'             => $analysis['color'],
                'badge_class'       => $analysis['badge_class'],
            ];
        });

        // Urutkan berdasarkan Total Skor tertinggi; jika seri, gunakan Impact tertinggi; jika masih seri, gunakan Feasibility (Bab 4.9)
        $sorted = $ideas->sort(function ($a, $b) {
            if ($b['total_score'] == $a['total_score']) {
                if ($b['avg_impact'] == $a['avg_impact']) {
                    return $b['avg_feasibility'] <=> $a['avg_feasibility'];
                }
                return $b['avg_impact'] <=> $a['avg_impact'];
            }
            return $b['total_score'] <=> $a['total_score'];
        })->values();

        // Identifikasi status seri (tie) jika ide peringkat #1 memiliki skor sama persis dengan peringkat #2
        $isTie = false;
        if ($sorted->count() > 1) {
            $first = $sorted->get(0);
            $second = $sorted->get(1);
            if ($first['total_score'] == $second['total_score'] && $first['avg_impact'] == $second['avg_impact'] && $first['avg_feasibility'] == $second['avg_feasibility']) {
                $isTie = true;
            }
        }

        return [$ideas, $sorted, $isTie];
    }

    public function landing()
    {
        [$ideas, $rankedIdeas, $isTie] = self::getAnalyzedIdeas();
        $topIdea = $rankedIdeas->first();
        $totalRespondents = Rating::distinct('respondent_name')->count('respondent_name');
        $totalVotes = Rating::count();
        $totalIdeas = $ideas->count();
        $trendingIdeas = $rankedIdeas->take(5);
        $recentActivities = ActivityLog::latest()->take(6)->get();

        // Target audiens / segmentasi kampanye aktif
        $categories = Idea::distinct('target_user')->pluck('target_user');

        return view('landing', compact(
            'ideas',
            'rankedIdeas',
            'topIdea',
            'isTie',
            'totalRespondents',
            'totalVotes',
            'totalIdeas',
            'trendingIdeas',
            'recentActivities',
            'categories'
        ));
    }

    public function index()
    {
        [$ideas, $rankedIdeas, $isTie] = self::getAnalyzedIdeas();
        $topIdea = $rankedIdeas->first();
        $totalRatings = Rating::count();
        $totalRespondents = Rating::distinct('respondent_name')->count('respondent_name');
        
        $activeIdeasCount = $ideas->count();
        $globalFeasibility = $activeIdeasCount > 0 ? round($ideas->avg('avg_feasibility'), 2) : 0.0;
        $globalImpact = $activeIdeasCount > 0 ? round($ideas->avg('avg_impact'), 2) : 0.0;

        // Distribusi 4 Kuadran
        $quadrantCounts = [
            'Prioritas Utama' => $ideas->where('quadrant', 'Prioritas Utama')->count(),
            'Potensi'         => $ideas->where('quadrant', 'Potensi')->count(),
            'Pertimbangkan'   => $ideas->where('quadrant', 'Pertimbangkan')->count(),
            'Tunda'           => $ideas->where('quadrant', 'Tunda')->count(),
        ];

        return view('dashboard', compact(
            'ideas',
            'rankedIdeas',
            'topIdea',
            'isTie',
            'totalRatings',
            'totalRespondents',
            'globalFeasibility',
            'globalImpact',
            'quadrantCounts'
        ));
    }

    public function report()
    {
        [$ideas, $rankedIdeas, $isTie] = self::getAnalyzedIdeas();
        $topIdea = $rankedIdeas->first();
        $totalRespondents = Rating::distinct('respondent_name')->count('respondent_name');
        $totalRatings = Rating::count();
        $globalFeasibility = round($ideas->avg('avg_feasibility'), 2);
        $globalImpact = round($ideas->avg('avg_impact'), 2);

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

    public function exportPdf()
    {
        [$ideas, $rankedIdeas] = self::getAnalyzedIdeas();
        $topIdea = $rankedIdeas->first();
        $totalRespondents = Rating::distinct('respondent_name')->count('respondent_name');

        $pdf = Pdf::loadView('report.pdf', compact('ideas', 'rankedIdeas', 'topIdea', 'totalRespondents'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Validasi-IDEA-LAB.pdf');
    }
}
