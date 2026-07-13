<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('name');
            $table->enum('program', ['tanwir_qurani', 'ojol_mengaji'])->nullable()->after('role');
        });

        // Email ga dipakai buat login lagi (diganti kode), jadi bebasin constraint-nya
        DB::statement("ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NULL");

        Schema::table('groups', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('name');
            $table->enum('program', ['tanwir_qurani', 'ojol_mengaji'])->nullable()->unique()->after('code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['code', 'program']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn(['code', 'program']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NOT NULL");
    }
};
