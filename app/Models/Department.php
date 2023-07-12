<?php

namespace App\Models;

use App\Events\DepartmentDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getAll(int $teamId): array
    {
        $data = $this->oldest('name')
            ->where('team_id', $teamId)
            ->select('id', 'name')
            ->get()
            ->toArray();

        return $data;
    }

    public function saveRecord(array $data): array
    {
        $department = $this->create($data);
        $response['id'] = $department->id;

        return $response;
    }

    public function updateRecord(Request $request): void
    {
        $this->where('id', $request->id)
            ->update(
                $request->except(['_method'])
            );
    }

    public function getData(int $id): array
    {
        $data = $this->where('id', $id)
            ->with(['team:id,name', 'users:department_id,id,first_name,last_name,email'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }

    public function deleteRecord(int $id): void
    {
        DepartmentDeleted::dispatch($this->find($id));
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

        if ($request->filled('name')) {
            $query = $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('team_id')) {
            $query = $query->where('team_id', request->team_id);
        }

        return $query;
    }
}
