<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'program',
        'guru_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Group $group) {
            if ($group->code || ! $group->program) {
                return;
            }

            $prefix = 'TQ';
            $count  = static::where('program', $group->program)->count();

            do {
                $count++;
                $code = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
            } while (static::where('code', $code)->exists());

            $group->code = $code;
        });
    }

    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function guru(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_group');
    }

    public function programLabel(): string
    {
        return 'Tanwir Qurani';
    }
}
