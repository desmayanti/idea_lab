<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\SurveyResponse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    public function index(Request $request)
    {
        $query = SurveyResponse::with('ratings.idea')->orderBy('submitted_at', 'desc');

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('respondent_name', 'like', "%{$s}%")
                  ->orWhere('respondent_class', 'like', "%{$s}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('respondent_class', $request->class);
        }

        $responses = $query->get();

        // Metrik analitik responden
        $totalVerified = SurveyResponse::count();
        $totalRatings = Rating::count();
        $avgFeasibilityGiven = $totalRatings > 0 ? round(Rating::avg('feasibility'), 2) : 0.0;
        $avgImpactGiven = $totalRatings > 0 ? round(Rating::avg('impact'), 2) : 0.0;
        
        // Completion rate: persentase responden yang menilai seluruh 10 ide
        $completedResponses = $responses->filter(function ($resp) {
            return $resp->ratings && $resp->ratings->count() >= 10;
        })->count();
        $completionRate = $responses->count() > 0 ? round(($completedResponses / $responses->count()) * 100) . '%' : '100%';

        $categories = SurveyResponse::distinct('respondent_class')->whereNotNull('respondent_class')->pluck('respondent_class');

        return view('respondents.index', compact(
            'responses',
            'totalVerified',
            'completionRate',
            'avgFeasibilityGiven',
            'avgImpactGiven',
            'categories'
        ));
    }

    public function show($id)
    {
        $response = SurveyResponse::with('ratings.idea')->findOrFail($id);
        return view('respondents.show', compact('response'));
    }

    public function destroy($id)
    {
        $response = SurveyResponse::findOrFail($id);
        $name = $response->respondent_name;

        // Hapus ratings terkait
        Rating::where('respondent_name', $name)->delete();
        $response->delete();

        ActivityLog::create([
            'user_name'   => 'Admin / Tim KIK',
            'action'      => 'Hapus Responden',
            'description' => "Menghapus data survei dan seluruh rating dari responden '{$name}'.",
        ]);

        return redirect()->route('respondents.index')->with('success', "Data responden '{$name}' berhasil dihapus. Kuadran telah dikalkulasi ulang!");
    }
}
