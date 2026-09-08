<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class ViewTugasGuru extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = TugasGuruResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Bagian Atas: Dibagi jadi 2 kolom besar (Informasi Tugas & Statistik) secara berdampingan
                Section::make('Informasi & Statistik Tugas')
                    ->schema([
                        TextEntry::make('title')->label('Judul Tugas'),
                        TextEntry::make('teacher.name')->label('Guru Pembuat')->default('-'),
                        TextEntry::make('type')
                            ->label('Tipe Tugas')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'voice_note' => '🎵 Voice Note',
                                'video'      => '🎬 Video',
                                'quiz'       => '📝 Kuis',
                                default      => $state,
                            }),
                        TextEntry::make('google_form_url')
                            ->label('Link Kuis')
                            ->url(fn ($record) => $record->google_form_url)
                            ->openUrlInNewTab()
                            ->visible(fn ($record) => filled($record->google_form_url)),
                        TextEntry::make('created_at')->label('Dibuat Pada')->dateTime('d M Y, H:i'),

                        // Statistik ringkas di dalam satu section atas
                        TextEntry::make('total_kumpul')
                            ->label('Total Mengumpulkan')
                            ->state(fn ($record) => $record->submissions()->count() . ' orang'),
                        TextEntry::make('total_pending')
                            ->label('⏳ Pending')
                            ->state(fn ($record) => $record->submissions()->where('status', 'pending')->count() . ' orang')
                            ->color('warning'),
                        TextEntry::make('total_diterima')
                            ->label('✅ Diterima')
                            ->state(fn ($record) => $record->submissions()->where('status', 'approved')->count() . ' orang')
                            ->color('success'),
                        TextEntry::make('total_ditolak')
                            ->label('❌ Ditolak')
                            ->state(fn ($record) => $record->submissions()->where('status', 'rejected')->count() . ' orang')
                            ->color('danger'),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }

    // Bagian Bawah: Tabel daftar pengumpulan peserta memenuhi lebar layar
    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn () => $this->record->submissions()->getQuery()
            )
            ->columns([
                ImageColumn::make('user.profile.foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                TextColumn::make('user.name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.code')
                    ->label('Kode Login')
                    ->badge()
                    ->color('success'),

                TextColumn::make('status')
                    ->label('Status Koreksi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'  => '⏳ Pending',
                        'approved' => '✅ Diterima',
                        'rejected' => '❌ Ditolak',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Waktu Kumpul')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ]);
    }
}