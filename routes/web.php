<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RespondentController;

// 1. Landing Page Interaktif 3D
Route::get('/', [DashboardController::class, 'landing'])->name('landing');

// 2. Dashboard Analitik & Matriks Kuadran
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 3. Form Input Survei Responden
Route::get('/survey', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');

// 4. Laporan Hasil Validasi & Export
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/export-csv', [ReportController::class, 'exportCsv'])->name('report.export.csv');
Route::get('/report/pdf', [DashboardController::class, 'exportPdf'])->name('report.pdf');

// 5. Manajemen 10 Ide (CRUD)
Route::resource('ideas', IdeaController::class);

// 6. Manajemen Responden & Detail Riwayat Penilaian
Route::get('/respondents', [RespondentController::class, 'index'])->name('respondents.index');
Route::get('/respondents/{id}', [RespondentController::class, 'show'])->name('respondents.show');
Route::delete('/respondents/{id}', [RespondentController::class, 'destroy'])->name('respondents.destroy');
