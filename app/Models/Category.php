<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'category_id');
    }

    public function saveRecord(array $data): array
    {
        $category = $this->create($data);
        $response['id'] = $category->id;

        return $response;
    }

    public function updateRecord(int $id, array $data): void
    {
        $this->where('id', $id)
            ->update($data);
    }

    public function deleteRecord(int $id): void
    {
        $this->destroy($id);
    }

    public function updateStatus(int $id, string $status): void
    {
        $this->where('id', $id)
            ->update([
                'status' => $status,
            ]);
    }

    public function getData(int $id): array
    {
        return $this->find($id)
            ->toArray();
    }

    public function getAll(): array
    {
        $data = $this->orderBy('name')
            ->select('id', 'name')
            ->where('status', 'Active')
            ->get()
            ->toArray();

        return $data;
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $page_number,
        ];

        $query = $this->applyFilters($request);
        $response['records_count'] = $query->count();
        $limit = config('app.page_length');
        $offset = ($request->page_number * $limit) - $limit;
        $response['page_count'] = ceil($response['records_count'] / $limit);

        $response['records'] = applyLimitOffset($query, $limit, $offset);

        return $response;
    }

    private function applyFilters(Request $request): Builder
    {
        $query = $this->orderBy('name');

        if ($request->filled('name')) {
            $query = $query->where('name', 'like', "%{$request->name}%");
        }

        return $query;
    }
}
