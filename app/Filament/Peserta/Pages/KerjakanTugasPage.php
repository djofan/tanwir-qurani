<?php

namespace App\Filament\Peserta\Pages;

use App\Models\Submission;
use App\Models\Task;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class KerjakanTugasPage extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = null;
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'filament.peserta.pages.kerjakan-tugas-page';
    protected static ?string $slug = 'tugas/{task}/kerjakan';

    public Task $task;
    public ?Submission $submission = null;

    public string $mode = 'record';
    public ?string $recordedFileData = null;
    public ?string $recordedFileName = null;
    
    public bool $hasRecording = false; 
    
    public $uploadedFile = null;
    public $screenshotFile = null;

    public function mount(Task $task): void
    {
        $this->task = $task;

        $this->submission = Submission::where('task_id', $task->id)
            ->where('student_id', Auth::id())
            ->latest()
            ->first();

        if ($this->submission && in_array($this->submission->status, ['pending', 'approved'])) {
            $this->redirect('/peserta/tugas');
            return;
        }

        if ($this->task->isLocked()) {
            Notification::make()
                ->title('Tugas ini sudah lewat deadline')
                ->body('Minta guru untuk memperpanjang deadline kalau kamu masih perlu mengerjakan.')
                ->danger()
                ->send();

            $this->redirect('/peserta/tugas');
            return;
        }

        if ($this->task->type === 'quiz') {
            $this->mode = 'upload';
        }
    }

    public function setMode(string $newMode): void
    {
        $this->mode = $newMode;
        
        $this->uploadedFile = null;
        $this->screenshotFile = null;
        $this->recordedFileData = null;
        $this->recordedFileName = null;
        $this->hasRecording = false;
    }

    public function saveRecordedData(string $base64Data, string $fileName): void
    {
        $this->recordedFileData = $base64Data;
        $this->recordedFileName = $fileName;
        $this->hasRecording = true; 
    }

    public function submit(): void
    {
        if ($this->task->isLocked()) {
            Notification::make()->title('Deadline sudah lewat, tidak bisa mengumpulkan lagi.')->danger()->send();
            $this->redirect('/peserta/tugas');
            return;
        }

        $studentId = Auth::id();
        $directory = "submissions/{$this->task->id}/{$studentId}";
        $filePath = null;

        if ($this->task->type === 'quiz') {
            $this->validate([
                'screenshotFile' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp'],
            ], [
                'screenshotFile.required' => 'Upload screenshot bukti pengerjaan kuis.',
                'screenshotFile.mimes'    => 'Format harus JPG, PNG, atau WEBP.',
            ]);

            if ($this->submission?->status === 'rejected') {
                if ($this->submission->screenshot_path) Storage::disk('public')->delete($this->submission->screenshot_path);
                if ($this->submission->file_path) Storage::disk('public')->delete($this->submission->file_path);
            }

            $screenshotPath = $this->screenshotFile->storeAs(
                $directory, 
                'screenshot_' . time() . '.' . $this->screenshotFile->getClientOriginalExtension(), 
                'public'
            );
            $filePath = $screenshotPath;

        } 
        else {
            if ($this->mode === 'record') {
                if (!$this->recordedFileData) {
                    Notification::make()->title('Belum ada rekaman!')->warning()->send();
                    return;
                }

                $base64 = preg_replace('/^data:\w+\/[\w\-\+]+;base64,/', '', $this->recordedFileData);
                $binary = base64_decode($base64);
                $fileName = 'rekaman_' . time() . '.webm';
                $fullPath = $directory . '/' . $fileName;

                Storage::disk('public')->put($fullPath, $binary);
                $filePath = $fullPath;

            } elseif ($this->mode === 'upload') {
                $this->validate([
                    'uploadedFile' => [
                        'required', 'file', 'max:51200',
                        $this->task->type === 'voice_note' ? 'mimes:mp3,wav,webm,ogg' : 'mimes:mp4,webm,mov',
                    ],
                ], [
                    'uploadedFile.required' => 'Pilih file terlebih dahulu.',
                    'uploadedFile.mimes'    => 'Format file tidak sesuai.',
                ]);

                $filePath = $this->uploadedFile->storeAs(
                    $directory,
                    'upload_' . time() . '.' . $this->uploadedFile->getClientOriginalExtension(),
                    'public'
                );
            }
        }

        if (!$filePath) {
            Notification::make()->title('Gagal memproses file!')->danger()->send();
            return;
        }

        $isLate = $this->task->isPastOriginalDeadline();

        $data = [
            'task_id'    => $this->task->id,
            'student_id' => $studentId,
            'file_path'  => $filePath,
            'status'     => 'pending',
            'is_late'    => $isLate,
        ];

        if ($this->task->type === 'quiz') {
            $data['screenshot_path'] = $filePath; 
        }

        if ($this->submission && $this->submission->status === 'rejected') {
            $data['attempts_count'] = $this->submission->attempts_count + 1;
            $this->submission->update($data);
        } else {
            $data['attempts_count'] = 1;
            Submission::create($data);
        }

        Notification::make()
            ->title('Tugas berhasil dikumpulkan!')
            ->body($isLate ? 'Dikumpulkan setelah deadline awal — ditandai terlambat. Tunggu verifikasi guru.' : 'Tunggu verifikasi dari guru.')
            ->success()
            ->send();

        $this->redirect(route('filament.peserta.pages.tugas'));
    }
}
