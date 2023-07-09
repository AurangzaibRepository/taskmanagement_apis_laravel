<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'logo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ($value ? asset("storage/images/teams/{$value}") : null),
        );
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function ($team) {
            $team->projects()->each(function ($project) {
                $project->delete();
            });
        });
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $request->pageNumber,
        ];

        $query = $this->applyFilters($request);
        $response['records_count'] = $query->count();
        $limit = config('app.page_length');
        $offset = ($request->pageNumber * $limit) - $limit;
        $response['page_count'] = ceil($response['records_count'] / $limit);

        $response['records'] = applyLimitOffset($query, $limit, $offset);

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

        return $query;
    }

    public function getAll(): array
    {
        $data = $this->orderBy('name')
            ->select('id', 'name')
            ->get()
            ->toArray();

        return $data;
    }

    public function getData(int $id): array
    {
        $data = $this->where('id', $id)
            ->with(['projects', 'users', 'departments'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }

    public function saveRecord(Request $request): array
    {
        $this->saveFile($request);

        $team = $this->create($request->all());
        $response['id'] = $team->id;

        return $response;
    }

    public function updateRecord(Request $request): void
    {
        $this->saveFile($request);

        $this->where('id', $request->id)
            ->update(
                $request->except(['_method', 'logo_file'])
            );
    }

    public function deleteRecord(int $id): void
    {
        $this->destroy($id);
    }

    private function saveFile(Request $request)
    {
        if ($request->hasFile('logo_file')) {
            $logoName = "{$request->code}.{$request->logo_file->extension()}";
            $request->logo_file->storeAs('images/teams', $logoName);

            $request->merge(['logo' => $logoName]);
        }
    }
}
