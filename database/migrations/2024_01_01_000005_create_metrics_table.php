<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('key_indicator_id')->constrained()->cascadeOnDelete();
            $table->string('metric_code');
            $table->string('metric_name');
            $table->text('description')->nullable();
            $table->string('data_template_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metrics');
    }
};
