<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
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

    public function deleteRecord(int $id): void
    {
        $this->destroy($id);
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $request->pageNumber,
        ];

        $query = $this->applyFilters($request);
        $response['records_count'] = $query->count();
        $pageLength = config('app.page_length');
        $offset = ($request->pageNumber * $pageLength) - $pageLength;
        $response['page_count'] = ceil($response['records_count'] / $pageLength);

        $response['records'] = applyLimitOffset($query, $pageLength, $offset);

        return $response;
    }

    private function applyFilters(Request $request): Builder
    {
        $query = $this->oldest('name');

        if ($request->filled('code')) {
            $query = $query->where('code', 'like', "%{$request->code}%");
        }

        if ($request->filled('name')) {
            $query = $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('team_id')) {
            $query = $query->where('team_id', $request->team_id);
        }

        return $query;
    }
}
