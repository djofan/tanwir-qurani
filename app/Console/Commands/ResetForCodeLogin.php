<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\Profile;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetForCodeLogin extends Command
{
    protected $signature = 'app:reset-for-code-login';

    protected $description = 'Hapus semua guru, peserta, kelompok, dan tugas lama, lalu update admin ke sistem login kode baru';

    public function handle(): int
    {
        if (! $this->confirm('Ini akan MENGHAPUS SEMUA guru, peserta, kelompok, dan tugas. Yakin lanjut?')) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        DB::transaction(function () {
            QuizAnswer::query()->delete();
            QuizQuestion::query()->delete();
            SubmissionLog::query()->delete();
            Submission::query()->delete();
            DB::table('task_group')->delete();
            DB::table('task_approvers')->delete();
            Task::query()->delete();
            Group::query()->delete();

            $guruDanPeserta = User::whereIn('role', ['guru', 'peserta'])->pluck('id');
            Profile::whereIn('user_id', $guruDanPeserta)->delete();
            User::whereIn('role', ['guru', 'peserta'])->delete();

            User::where('role', 'admin')->update([
                'code'     => 'ADMINPTQDOM',
                'password' => Hash::make('ADMINPTQDOM001'),
            ]);
        });

        $this->info('Selesai! Semua guru/peserta/kelompok/tugas lama sudah dihapus.');
        $this->info('Login admin sekarang: Kode = ADMINPTQDOM, Password = ADMINPTQDOM001');

        return self::SUCCESS;
    }
}
