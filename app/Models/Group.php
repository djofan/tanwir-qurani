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
    ];

    protected static function booted(): void
    {
        static::creating(function (Group $group) {
            if ($group->code || ! $group->program) {
                return;
            }

            $prefix = $group->program === 'ojol_mengaji' ? 'OM' : 'TQ';
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

    public function tasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_group');
    }

    public function programLabel(): string
    {
        return match ($this->program) {
            'ojol_mengaji'  => 'Ojol Mengaji',
            'tanwir_qurani' => 'Tanwir Qurani',
            default         => '-',
        };
    }
}
