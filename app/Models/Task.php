<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'category_id',
        'user_id',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(TaskImage::class, 'task_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAll(int $projectId): array
    {
        $data = $this->oldest('title')
            ->where('project_id', $projectId)
            ->select('id', 'title')
            ->get()
            ->toArray();

        return $data;
    }

    public function saveRecord(array $data): array
    {
        $task = $this->create($data);

        $response['id'] = $task->id;

        return $response;
    }

    public function updateRecord(Request $request): void
    {
        $this->where('id', $request->id)
            ->update($request->except(['_method']));
    }

    public function getData(int $id): array
    {
        $data = $this->where('id', $id)
            ->with(['project:id,name', 'category:id,name', 'user:id,first_name,last_name'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }

    public function deleteRecord(int $id): void
    {
        $this->destroy($id);
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $request->page_number,
        ];

        $query = $this->applyFilters($request);
    }

    private function applyFilters(Request $request): Builder
    {
        $query = $this->latest('id');

        if ($request->filled('title')) {
            $query = $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->filled('project_id')) {
            $query = $query->where('project_id', $request->project_id);
        }

        if ($reqeust->filled('category_id')) {
            $query = $query->where('category_id', $request->category_id);
        }

        if ($query->filled('user_id')) {
            $query = $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query = $query->where('status', $request->status);
        }

        return $query;
    }
}
