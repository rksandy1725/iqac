<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('target_group', ['student', 'parent', 'employer', 'alumni', 'faculty'])->default('student');
            $table->foreignId('criterion_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_surveys');
    }
};
