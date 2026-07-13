<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'submission_id',
        'teacher_id',
        'status_at_time',
        'feedback',
        'attempt_number',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function submission(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}