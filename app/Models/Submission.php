<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'student_id',
        'file_path',
        'screenshot_path',
        'status',
        'attempts_count',
        'score',
        'is_late',
    ];

    protected $casts = [
        'is_late' => 'boolean',
    ];

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubmissionLog::class);
    }

    public function latestLog(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SubmissionLog::class)->latestOfMany();
    }

    public function quizAnswers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }
}