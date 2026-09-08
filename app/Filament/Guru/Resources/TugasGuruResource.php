<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\TugasGuruResource\Pages;
use App\Models\Task;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TugasGuruResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Tugas';

    protected static ?string $modelLabel = 'Tugas';

    protected static ?string $pluralModelLabel = 'Semua Tugas';

    protected static ?string $slug = 'tugas';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['teacher', 'groups', 'questions', 'approvers']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Tugas')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Tugas')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Tipe Tugas')
                            ->options([
                                'voice_note' => '🎵 Voice Note (Audio)',
                                'video'      => '🎬 Video',
                                'quiz'       => '📝 Kuis (Google Form)',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Textarea::make('description')
                            ->label('Deskripsi / Perintah')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        DateTimePicker::make('deadline')
                            ->label('Deadline')
                            ->native(false)
                            ->seconds(false)
                            ->minDate(now())
                            ->required()
                            ->helperText('Wajib diisi — batas waktu pengumpulan tugas ini'),

                    ])->columns(2),

                Section::make('Soal Kuis')
                    ->description('Buat soal pilihan ganda. Nilai murid dihitung otomatis begitu kuis dikumpulkan.')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->label('Daftar Soal')
                            ->schema([
                                Textarea::make('question')
                                    ->label('Pertanyaan')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('option_a')
                                    ->label('Pilihan A')
                                    ->required(),

                                TextInput::make('option_b')
                                    ->label('Pilihan B')
                                    ->required(),

                                TextInput::make('option_c')
                                    ->label('Pilihan C')
                                    ->required(),

                                TextInput::make('option_d')
                                    ->label('Pilihan D')
                                    ->required(),

                                Radio::make('correct_option')
                                    ->label('Jawaban Benar')
                                    ->options([
                                        'a' => 'A',
                                        'b' => 'B',
                                        'c' => 'C',
                                        'd' => 'D',
                                    ])
                                    ->required()
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'Soal baru')
                            ->addActionLabel('+ Tambah Soal')
                            ->minItems(1)
                            ->reorderable()
                            ->orderColumn('order')
                            ->collapsible()
                            ->required(fn ($get) => $get('type') === 'quiz')
                            ->columnSpanFull(),
                    ])
                    ->hidden(fn ($get) => $get('type') !== 'quiz'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('type')
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

                TextColumn::make('deadline')
                    ->label('Deadline')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Bebas')
                    ->badge()
                    ->color(fn (Task $record) => $record->isLocked() ? 'danger' : ($record->deadline ? 'success' : 'gray'))
                    ->formatStateUsing(fn ($state, Task $record) => $state ? \Illuminate\Support\Carbon::parse($state)->format('d M Y, H:i') . ($record->isLocked() ? ' 🔒' : '') : 'Bebas')
                    ->sortable(),

                // Kolom di bawah ini dibuat toggleable agar bisa dipilih/disembunyikan via tombol pengaturan kolom
                TextColumn::make('groups.name')
                    ->label('Kelompok')
                    ->badge()
                    ->separator(',')
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true), // Default tersembunyi agar mobile bersih

                TextColumn::make('teacher.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (Task $record) => $record->teacher_id === Auth::id() ? 'success' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('questions_count')
                    ->label('Jumlah Soal')
                    ->counts('questions')
                    ->formatStateUsing(fn ($state, Task $record) => $record->type === 'quiz' ? "{$state} soal" : '-')
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('submissions_count')
                    ->label('Dikumpulkan')
                    ->counts('submissions')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('submissions_pending_count')
                    ->label('Pending')
                    ->counts(['submissions as submissions_pending_count' => fn (Builder $q) => $q->where('status', 'pending')])
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe Tugas')
                    ->options([
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                    ]),

                SelectFilter::make('teacher_id')
                    ->label('Filter Guru')
                    ->options(
                        User::where('role', 'guru')
                            ->where('status', true)
                            ->pluck('name', 'id')
                    ),
            ])
            ->actions([
                ViewAction::make(),

                Action::make('lihatHasilKuis')
                    ->label('Hasil Kuis')
                    ->icon('heroicon-o-chart-bar')
                    ->color('success')
                    ->visible(fn (Task $record) => $record->type === 'quiz' && $record->canBeReviewedBy(Auth::id()))
                    ->url(fn (Task $record) => route('filament.guru.pages.tugas.{task}.hasil-kuis', ['task' => $record->id])),

                Action::make('lihatHasilTugas')
                    ->label('Hasil Tugas')
                    ->icon('heroicon-o-chart-bar')
                    ->color('success')
                    ->visible(fn (Task $record) => in_array($record->type, ['video', 'voice_note']) && $record->canBeReviewedBy(Auth::id()))
                    ->url(fn (Task $record) => route('filament.guru.pages.tugas.{task}.hasil-tugas', ['task' => $record->id])),

                Action::make('extendDeadline')
                    ->label('Perpanjang')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->visible(fn (Task $record) => $record->teacher_id === Auth::id() && $record->isLocked())
                    ->schema([
                        TextInput::make('hours')
                            ->label('Tambah berapa jam?')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(72)
                            ->default(2)
                            ->helperText('Murid yang ngumpul di jam tambahan ini otomatis ditandai "terlambat"'),
                    ])
                    ->action(function (Task $record, array $data) {
                        $record->extendDeadline((int) $data['hours']);

                        Notification::make()
                            ->title('Deadline diperpanjang ' . $data['hours'] . ' jam')
                            ->success()
                            ->send();
                    }),

                EditAction::make()
                    ->visible(fn (Task $record) => $record->teacher_id === Auth::id()),
                DeleteAction::make()
                    ->visible(fn (Task $record) => $record->teacher_id === Auth::id()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTugasGurus::route('/'),
            'create' => Pages\CreateTugasGuru::route('/create'),
            'view'  => Pages\ViewTugasGuru::route('/{record}'),
            'edit'   => Pages\EditTugasGuru::route('/{record}/edit'),
        ];
    }
}