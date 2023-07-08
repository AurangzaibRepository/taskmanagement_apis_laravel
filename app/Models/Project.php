<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

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

    protected $fillable = [
        'code',
        'name',
        'description',
        'team_id',
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
            ->with(['team:id,name', 'tasks:project_id,title,status,category_id', 'tasks.category:id,name'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }

    public function saveRecord(array $data): array
    {
        $project = $this->create($data);
        $response['id'] = $project->id;

        return $response;
    }

    public function updateRecord(Request $request): void
    {
        $this->where('id', $request->id)
            ->update(
                $request->except(['_method']),
            );
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $request->pageNumber,
        ];
    }
}
