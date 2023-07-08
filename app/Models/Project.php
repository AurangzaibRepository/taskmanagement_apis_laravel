<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getAll(int $teamId): array
    {
        $data = $this->where('team_id', $teamId)
            ->select('id', 'name')
            ->oldest('name')
            ->get()
            ->toArray();

        return $data;
    }

    public function getData(int $id): array
    {
        $data = $this->where('id', $id)
            ->with(['team:id,name', 'tasks:id,project_id,title,status'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }
}
