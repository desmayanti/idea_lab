<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Contoh: IDE-01
            $table->string('title');
            $table->text('description');
            $table->string('target_user'); // KYOTO STORE (Penjual) / Sabrina (Pembeli)
            $table->text('problem_solved');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
