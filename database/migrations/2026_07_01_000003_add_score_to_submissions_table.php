<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->unsignedTinyInteger('score')->nullable()->after('attempts_count');
        });

        // file_path wajib diisi di skema lama (voice_note/video/quiz-screenshot).
        // Kuis native ga upload file, jadi kolom ini harus boleh kosong.
        // Pakai raw statement biar ga butuh doctrine/dbal.
        DB::statement("ALTER TABLE submissions MODIFY COLUMN file_path VARCHAR(255) NULL");
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('score');
        });

        DB::statement("ALTER TABLE submissions MODIFY COLUMN file_path VARCHAR(255) NOT NULL");
    }
};
