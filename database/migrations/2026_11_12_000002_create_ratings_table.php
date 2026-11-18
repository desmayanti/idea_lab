<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_id')->constrained('ideas')->onDelete('cascade');
            $table->unsignedBigInteger('survey_response_id')->nullable();
            $table->string('respondent_name');
            $table->string('respondent_class')->default('XI PPLG 2');
            $table->unsignedTinyInteger('feasibility'); // Skala 1 - 5
            $table->unsignedTinyInteger('impact');      // Skala 1 - 5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
