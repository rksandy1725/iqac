<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('key_indicator_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('metric_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('academic_year');
            $table->enum('status', ['planned', 'in_progress', 'completed'])->default('planned');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('evidence_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
