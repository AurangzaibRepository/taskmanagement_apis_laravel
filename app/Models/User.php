<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'team_id',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value, array $attributes) => "{$attributes['first_name']} {$attributes['last_name']}",
        );
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsto(Department::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getAll(int $teamId, int $departmentId): array
    {
        $data = $this->where('team_id', $teamId)
            ->where('department_id', $departmentId)
            ->selectRaw('id, concat(first_name, " ", last_name) name')
            ->oldest('first_name')
            ->get()
            ->toArray();

        return $data;
    }
}
