<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak_didiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama');
            $table->unsignedTinyInteger('usia')->nullable();
            $table->string('kelas')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('nomor_orang_tua')->nullable();
            $table->text('progres_belajar')->nullable();
            $table->timestamps();

            $table->index('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak_didiks');
    }
};
