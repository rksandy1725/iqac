<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('key_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_id')->constrained()->cascadeOnDelete();
            $table->string('ki_code');
            $table->string('ki_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('key_indicators');
    }
};
