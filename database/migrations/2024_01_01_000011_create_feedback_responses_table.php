<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('feedback_surveys')->cascadeOnDelete();
            $table->string('respondent_name')->nullable();
            $table->string('respondent_email')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comments')->nullable();
            $table->json('answers')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_responses');
    }
};
