<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->nullable()->constrained('surveys')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('respondent_name');
            $table->string('respondent_class')->default('XI PPLG 2');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique('respondent_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
