<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('restrict');
            $table->enum('status_at_time', ['approved', 'rejected']);
            $table->text('feedback')->nullable();
            $table->integer('attempt_number');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_logs');
    }
};