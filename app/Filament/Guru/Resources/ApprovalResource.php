<?php

namespace App\Filament\Guru\Resources;
use App\Filament\Guru\Resources\ApprovalResource\Pages;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\Task;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ApprovalResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static ?string $navigationLabel = 'Approval Tugas';

    protected static ?string $modelLabel = 'Submission';

    protected static ?string $pluralModelLabel = 'Approval Tugas';

    protected static ?string $slug = 'approval';

    public static function getEloquentQuery(): Builder
    {
        $guruId = Auth::id();

        return parent::getEloquentQuery()
            ->where('status', 'pending')
            // Kuis native auto-graded & auto-approved, jadi ga pernah masuk sini.
            ->whereHas('task', fn (Builder $q) => $q->where('type', '!=', 'quiz'))
            // Cuma pembuat tugas atau guru yang ditunjuk jadi approver yang bisa lihat/review.
            ->whereHas('task', function (Builder $q) use ($guruId) {
                $q->where('teacher_id', $guruId)
                    ->orWhereHas('approvers', fn (Builder $q2) => $q2->where('users.id', $guruId));
            })
            ->with(['task', 'task.teacher', 'task.approvers', 'student', 'logs.teacher']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peserta')
                    ->schema([
                        TextEntry::make('student.name')
                            ->label('Nama Peserta'),

                        TextEntry::make('student.email')
                            ->label('Email'),

                        TextEntry::make('task.title')
                            ->label('Judul Tugas'),

                        TextEntry::make('task.teacher.name')
                            ->label('Guru Pembuat'),

                        TextEntry::make('task.type')
                            ->label('Tipe')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'voice_note' => '🎵 Voice Note',
                                'video'      => '🎬 Video',
                                'quiz'       => '📝 Kuis',
                                default      => $state,
                            })
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'voice_note' => 'info',
                                'video'      => 'warning',
                                'quiz'       => 'success',
                                default      => 'gray',
                            }),

                        TextEntry::make('attempts_count')
                            ->label('Percobaan Ke'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'pending'  => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default    => 'gray',
                            }),
                    ])->columns(3),

                Section::make('Link Google Form')
                    ->schema([
                        TextEntry::make('task.google_form_url')
                            ->label('Link Form')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->color('info')
                            ->placeholder('Tidak ada link'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type === 'quiz'),

                Section::make('File Rekaman')
                    ->schema([
                        ViewEntry::make('file_path')
                            ->label('Player')
                            ->view('filament.infolists.components.media-player'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type !== 'quiz'),

                Section::make('Bukti Screenshot')
                    ->schema([
                        ViewEntry::make('screenshot_path')
                            ->label('Screenshot')
                            ->view('filament.infolists.components.screenshot-viewer'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type === 'quiz'),

                Section::make('Riwayat Koreksi')
                    ->schema([
                        ViewEntry::make('logs')
                            ->label('Riwayat')
                            ->view('filament.infolists.components.submission-logs'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('task.title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('task.teacher.name')
                    ->label('Guru Pembuat')
                    ->searchable()
                    ->badge()
                    ->color(fn (Submission $record) => $record->task?->teacher_id === Auth::id() ? 'success' : 'gray'),

                TextColumn::make('task.type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                        default      => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'voice_note' => 'info',
                        'video'      => 'warning',
                        'quiz'       => 'success',
                        default      => 'gray',
                    }),

                TextColumn::make('attempts_count')
                    ->label('Percobaan'),

                TextColumn::make('created_at')
                    ->label('Dikumpulkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('task_id')
                    ->label('Filter Tugas')
                    ->options(Task::pluck('title', 'id')),

                SelectFilter::make('type')
                    ->label('Tipe Tugas')
                    ->options([
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'])) return $query;
                        return $query->whereHas('task', fn ($q) => $q->where('type', $data['value']));
                    }),
            ])
            ->actions([
                ViewAction::make()->label('Review'),

                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Tugas Ini?')
                    ->modalDescription('Tugas peserta akan ditandai sebagai selesai.')
                    ->action(function (Submission $record) {
                        $record->update(['status' => 'approved']);
                        SubmissionLog::create([
                            'submission_id'  => $record->id,
                            'teacher_id'     => Auth::id(),
                            'status_at_time' => 'approved',
                            'feedback'       => 'Tugas disetujui.',
                            'attempt_number' => $record->attempts_count,
                        ]);
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->form([
                        Textarea::make('feedback')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(4)
                            ->placeholder('Contoh: Screenshot tidak terbaca, jawaban salah...'),
                    ])
                    ->action(function (Submission $record, array $data) {
                        $record->update(['status' => 'rejected']);
                        SubmissionLog::create([
                            'submission_id'  => $record->id,
                            'teacher_id'     => Auth::id(),
                            'status_at_time' => 'rejected',
                            'feedback'       => $data['feedback'],
                            'attempt_number' => $record->attempts_count,
                        ]);
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovals::route('/'),
            'view'  => Pages\ViewApproval::route('/{record}'),
        ];
    }
}