<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aqar_reports', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year');
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->json('json_data')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('submitted_to_naac_on')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aqar_reports');
    }
};
