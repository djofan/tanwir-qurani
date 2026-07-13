<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // deadline = batas aktif sekarang (bisa diperpanjang guru)
            $table->timestamp('deadline')->nullable()->after('description');
            // original_deadline = batas awal sebelum diperpanjang, dipakai buat nentuin status "terlambat"
            $table->timestamp('original_deadline')->nullable()->after('deadline');
        });

        Schema::create('task_approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['task_id', 'user_id']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->boolean('is_late')->default(false)->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'original_deadline']);
        });

        Schema::dropIfExists('task_approvers');

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('is_late');
        });
    }
};
