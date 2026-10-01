<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->enum('meeting_type', ['iqac', 'department', 'other'])->default('iqac');
            $table->string('title');
            $table->date('meeting_date');
            $table->time('meeting_time')->nullable();
            $table->string('venue')->nullable();
            $table->text('agenda')->nullable();
            $table->text('minutes')->nullable();
            $table->text('action_items')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
