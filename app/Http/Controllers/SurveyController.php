<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Rating;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function create()
    {
        $ideas = Idea::where('status', 'active')->orderBy('id')->get();
        if ($ideas->isEmpty()) {
            $ideas = Idea::orderBy('id')->get();
        }
        $survey = Survey::where('is_open', true)->first();
        return view('survey.create', compact('ideas', 'survey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'respondent_name'       => 'required|string|max:100',
            'respondent_class'      => 'required|string|max:50',
            'ratings'               => 'required|array',
            'ratings.*.feasibility' => 'required|integer|min:1|max:5',
            'ratings.*.impact'      => 'required|integer|min:1|max:5',
            'ratings.*.comment'     => 'nullable|string|max:500',
        ], [
            'respondent_name.required'       => 'Nama responden wajib diisi.',
            'respondent_class.required'      => 'Kelas responden wajib diisi.',
            'ratings.*.feasibility.required' => 'Nilai Feasibility wajib dipilih (1-5).',
            'ratings.*.impact.required'      => 'Nilai Impact wajib dipilih (1-5).',
        ]);

        $respondentName = trim($request->respondent_name);

        // Pencegahan pengiriman survei berulang oleh nama responden yang sama (Bab 4.4 & SRS Constraint)
        $alreadySubmitted = Rating::where('respondent_name', $respondentName)->exists()
            || SurveyResponse::where('respondent_name', $respondentName)->exists();

        if ($alreadySubmitted) {
            return back()->withErrors([
                'respondent_name' => "Nama responden '{$respondentName}' sudah mengirimkan survei sebelumnya. Gunakan nama responden lain."
            ])->withInput();
        }

        $survey = Survey::where('is_open', true)->first();

        // Buat record survei response induk
        $surveyResponse = SurveyResponse::create([
            'survey_id'        => $survey ? $survey->id : null,
            'respondent_name'  => $respondentName,
            'respondent_class' => $request->respondent_class,
            'submitted_at'     => now(),
        ]);

        // Simpan setiap penilaian 10 ide
        foreach ($request->ratings as $ideaId => $score) {
            Rating::create([
                'idea_id'            => $ideaId,
                'survey_response_id' => $surveyResponse->id,
                'respondent_name'    => $respondentName,
                'respondent_class'   => $request->respondent_class,
                'feasibility'        => (int) $score['feasibility'],
                'impact'             => (int) $score['impact'],
                'comment'            => $score['comment'] ?? null,
            ]);
        }

        // Catat log aktivitas
        ActivityLog::create([
            'user_name'   => $respondentName,
            'action'      => 'Pengisian Survei',
            'description' => "Responden '{$respondentName}' ({$request->respondent_class}) berhasil mengirimkan penilaian untuk " . count($request->ratings) . " ide.",
        ]);

        return redirect()->route('dashboard')->with('success', "Terima kasih, {$respondentName}! Survei 10 Ide berhasil disimpan dan otomatis dikalkulasi ke dalam Kuadran.");
    }
}
