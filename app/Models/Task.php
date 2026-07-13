<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'type',
        'google_form_url',
        'deadline',
        'original_deadline',
    ];

    protected $casts = [
        'deadline'          => 'datetime',
        'original_deadline' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Task $task) {
            if ($task->deadline && ! $task->original_deadline) {
                $task->original_deadline = $task->deadline;
            }
        });
    }

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'task_group');
    }

    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function approvers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_approvers');
    }

    /**
     * Guru yang boleh approve/reject submission tugas ini: pembuat + approver tambahan.
     */
    public function canBeReviewedBy(int $userId): bool
    {
        if ($this->teacher_id === $userId) {
            return true;
        }

        return $this->approvers()->where('users.id', $userId)->exists();
    }

    public function isLocked(): bool
    {
        return $this->deadline !== null && now()->gt($this->deadline);
    }

    /**
     * Submission dianggap terlambat kalau dikumpulkan setelah deadline ASLI
     * (sebelum diperpanjang guru). Kalau belum pernah ada deadline, ga pernah terlambat.
     */
    public function isPastOriginalDeadline(): bool
    {
        return $this->original_deadline !== null && now()->gt($this->original_deadline);
    }

    public function extendDeadline(int $hours): void
    {
        $this->update(['deadline' => now()->addHours($hours)]);
    }

    public function isQuiz(): bool
    {
        return $this->type === 'quiz';
    }

    public function isVisibleTo(User $student): bool
    {
        if (! $student->profile?->group_id) {
            return false;
        }
        return $this->groups()->where('groups.id', $student->profile->group_id)->exists();
    }
}