<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Sebelumnya program dibikin unique (cuma boleh 1 kelompok/program).
            // Ternyata boleh banyak kelompok per program (TQ001, TQ002, ... , OM001, OM002, ...),
            // jadi constraint unique-nya dilepas di sini.
            $table->dropUnique(['program']);
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->unique('program');
        });
    }
};
