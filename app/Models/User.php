<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

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
        'password',
        'team_id',
        'department_id',
        'picture',
        'role',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value, array $attributes) => "{$attributes['first_name']} {$attributes['last_name']}",
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
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

    public function saveRecord(Request $request): array
    {
        $this->saveFile($request);

        $user = $this->create($request->all());
        $response['id'] = $user->id;

        return $response;
    }
}
