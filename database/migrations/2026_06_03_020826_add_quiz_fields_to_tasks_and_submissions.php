<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('google_form_url')->nullable()->after('description');
        });

        DB::statement("ALTER TABLE tasks MODIFY COLUMN type ENUM('voice_note', 'video', 'quiz') NOT NULL");

        Schema::table('submissions', function (Blueprint $table) {
            $table->string('screenshot_path')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('google_form_url');
        });

        DB::statement("ALTER TABLE tasks MODIFY COLUMN type ENUM('voice_note', 'video') NOT NULL");

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('screenshot_path');
        });
    }
};