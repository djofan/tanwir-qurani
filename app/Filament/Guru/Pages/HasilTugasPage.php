<?php

namespace App\Filament\Guru\Pages;

use App\Models\Submission;
use App\Models\Task;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class HasilTugasPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = null;
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'filament.guru.pages.hasil-tugas-page';
    protected static ?string $slug = 'tugas/{task}/hasil-tugas';

    public Task $task;

    public function mount(Task $task): void
    {
        $this->task = $task;
    }

    public function getTitle(): string
    {
        return 'Hasil Tugas: ' . $this->task->title;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Submission::query()
                    ->where('task_id', $this->task->id)
                    ->with(['student', 'logs.teacher'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('attempts_count')
                    ->label('Percobaan Ke'),

                Tables\Columns\TextColumn::make('is_late')
                    ->label('Ketepatan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Terlambat' : 'Tepat Waktu')
                    ->color(fn ($state) => $state ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikumpulkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Action::make('lihatRiwayat')
                    ->label('Lihat Riwayat')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn (Submission $record) => 'Riwayat ' . $record->student?->name)
                    ->modalContent(fn (Submission $record) => view('filament.guru.partials.riwayat-submission', [
                        'submission' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('2xl'),
            ])
            ->emptyStateHeading('Belum ada peserta yang mengumpulkan tugas ini');
    }
}
