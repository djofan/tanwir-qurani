<?php

namespace App\Filament\Peserta\Widgets;

use App\Models\Submission;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PesertaStatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $student   = Auth::user();
        $studentId = $student->id;
        $groupId   = $student->profile?->group_id;

        $totalTugas = Task::when($groupId, function ($q) use ($groupId) {
            $q->whereHas('groups', fn ($q2) => $q2->where('groups.id', $groupId));
        }, function ($q) {
            $q->whereRaw('1 = 0');
        })->count();

        $dikerjakan = Submission::where('student_id', $studentId)->pluck('task_id');

        $belumDikerjakan = $totalTugas - $dikerjakan->unique()->count();
        if ($belumDikerjakan < 0) $belumDikerjakan = 0;

        $menunggu = Submission::where('student_id', $studentId)
            ->where('status', 'pending')->count();

        $harusUlang = Submission::where('student_id', $studentId)
            ->where('status', 'rejected')->count();

        $selesai = Submission::where('student_id', $studentId)
            ->where('status', 'approved')->count();

        return [
            Stat::make('Belum Dikerjakan', $belumDikerjakan)
                ->description($belumDikerjakan > 0 ? '⚠️ Ada tugas yang belum kamu sentuh' : 'Semua tugas sudah dikerjakan 🎉')
                ->descriptionIcon($belumDikerjakan > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($belumDikerjakan > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-clipboard-document-list')
                ->extraAttributes($belumDikerjakan > 0 ? [
                    'class' => 'ring-2 ring-danger-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 animate-pulse',
                ] : []),

            Stat::make('Menunggu Koreksi', $menunggu)
                ->description('Sudah dikumpul, belum dinilai')
                ->color('info'),

            Stat::make('Harus Diulang', $harusUlang)
                ->description('Ditolak guru, perlu diperbaiki')
                ->color('danger'),

            Stat::make('Selesai', $selesai)
                ->description('Tugas yang sudah disetujui')
                ->color('success'),
        ];
    }
}