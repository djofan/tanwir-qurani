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

class HasilKuisPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = null;
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'filament.guru.pages.hasil-kuis-page';
    protected static ?string $slug = 'tugas/{task}/hasil-kuis';

    public Task $task;

    public function mount(Task $task): void
    {
        $this->task = $task->load('questions');
    }

    public function getTitle(): string
    {
        return 'Hasil Kuis: ' . $this->task->title;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Submission::query()
                    ->where('task_id', $this->task->id)
                    ->with(['student', 'quizAnswers.question'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Murid')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->badge()
                    ->color(fn ($state) => $state >= 70 ? 'success' : ($state >= 50 ? 'warning' : 'danger'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('benar')
                    ->label('Benar/Total')
                    ->getStateUsing(fn (Submission $record) => $record->quizAnswers->where('is_correct', true)->count() . ' / ' . $record->quizAnswers->count()),

                Tables\Columns\IconColumn::make('is_late')
                    ->label('Terlambat')
                    ->boolean()
                    ->trueIcon('heroicon-o-clock')
                    ->falseIcon('heroicon-o-check')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikumpulkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('score', 'desc')
            ->actions([
                Action::make('lihatJawaban')
                    ->label('Lihat Jawaban')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn (Submission $record) => 'Jawaban ' . $record->student?->name)
                    ->modalContent(fn (Submission $record) => view('filament.guru.partials.jawaban-kuis', [
                        'submission' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ])
            ->emptyStateHeading('Belum ada murid yang mengerjakan kuis ini');
    }
}