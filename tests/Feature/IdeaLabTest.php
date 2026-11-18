<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\Rating;

class IdeaLabTest extends TestCase
{
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Test Ideas.');
        $response->assertSee('Analyze Data.');
        $response->assertSee('Build Better.');
        $response->assertSee('KYOTO STORE');
        $response->assertSee('Sabrina');
    }

    public function test_dashboard_renders_with_quadrants_and_top_idea(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Rekomendasi Ide Terpilih');
        $response->assertSee('Prioritas Utama');
        $response->assertSee('quadrantMatrixChart');
        $response->assertSee('totalScoreChart');
        $response->assertSee('scatter3DContainer');
    }

    public function test_survey_create_page_renders_10_ideas(): void
    {
        $response = $this->get('/survey');
        $response->assertStatus(200);
        $response->assertSee('Form Penilaian 10 Ide Solusi Digital');
        $response->assertSee('IDE-01');
        $response->assertSee('IDE-10');
    }

    public function test_survey_submission_and_duplicate_prevention(): void
    {
        $ideas = Idea::all();
        $ratingsData = [];
        foreach ($ideas as $idea) {
            $ratingsData[$idea->id] = [
                'feasibility' => 4,
                'impact'      => 5,
                'comment'     => 'Uji coba otomatis form validasi.'
            ];
        }

        $uniqueName = 'Uji Responden Automated ' . uniqid();

        // 1. Submit survey pertama
        $response = $this->post('/survey', [
            'respondent_name'  => $uniqueName,
            'respondent_class' => 'XI PPLG 2',
            'ratings'          => $ratingsData,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('ratings', [
            'respondent_name' => $uniqueName,
        ]);

        // 2. Submit kedua dengan nama yang sama harus ditolak (anti-duplikasi)
        $duplicateResponse = $this->post('/survey', [
            'respondent_name'  => $uniqueName,
            'respondent_class' => 'XI PPLG 2',
            'ratings'          => $ratingsData,
        ]);

        $duplicateResponse->assertSessionHasErrors('respondent_name');
    }

    public function test_report_page_and_csv_export(): void
    {
        $response = $this->get('/report');
        $response->assertStatus(200);
        $response->assertSee('Laporan Hasil Validasi 10 Solusi Digital');
        $response->assertSee('reportMatrixChart');
        $response->assertSee('reportScoreChart');

        $csvResponse = $this->get('/report/export-csv');
        $csvResponse->assertStatus(200);
        $csvResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_ideas_crud_and_respondents_pages(): void
    {
        $ideasResponse = $this->get('/ideas');
        $ideasResponse->assertStatus(200);
        $ideasResponse->assertSee('Daftar 10 Ide E-Commerce');

        $respondentsResponse = $this->get('/respondents');
        $respondentsResponse->assertStatus(200);
        $respondentsResponse->assertSee('Daftar Responden Survei');
    }
}
