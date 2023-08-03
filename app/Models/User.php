<?php

namespace App\Models;

use App\Events\UserDeleted;
use App\Mail\VerificationEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'password',
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

    protected function picture(): Attribute
    {
        return Attribute::make(
            get: fn (string $value = null) => ($value ? asset("storage/images/users/{$value}") : null),
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

    public function updateRecord(Request $request): void
    {
        $this->saveFile($request);

        $user = $this->where('id', $request->id)
            ->update($request->except(['_method', 'image']));
    }

    public function getData(int $id): array
    {
        $data = $this->where('id', $id)
            ->with(['team:id,name', 'department:id,name', 'tasks:id,title,status,user_id'])
            ->get()
            ->toArray();

        return Arr::first($data);
    }

    private function saveFile(Request $request): void
    {
        $id = $request->id;

        if (! $request->id) {
            $latestUser = $this->latest('id')->first();
            $id = $latestUser->id + 1;
        }

        if ($request->hasFile('image')) {
            $fileName = "{$id}.{$request->image->extension()}";
            $request->image->storeAs('images/users', $fileName);

            $request->merge(['picture' => $fileName]);
        }
    }

    public function getListing(Request $request): array
    {
        $response = [
            'page_number' => $request->page_number,
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
        $query = $this->oldest('first_name')
            ->where('role', '!=', 'Admin');

        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        if ($request->filled('team_id')) {
            $query->where('team_id', $request->team_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('name')) {
            $query->where(function ($query) use ($request) {
                $query->where('first_name', 'like', "%{$request->name}%")
                    ->orWhere('last_name', 'like', "%{$request->name}%");
            });
        }

        return $query;
    }

    public function deleteRecord(int $id): void
    {
        UserDeleted::dispatch($this->find($id));
        $this->destroy($id);
    }

    public function updatePassword(Request $request): void
    {
        $this->where('email', $request->email)
            ->update([
                'password' => bcrypt($request->new_password),
            ]);
    }

    public function generateVerificationCode(string $email): void
    {
        $this->where('email', $email)
            ->update([
                'verification_code' => bcrypt($email),
            ]);

        $user = $this->where('email', $email)
            ->first();

        Mail::to($email)
            ->send(new VerificationEmail($user));
    }

    public function getUser(string $email): User
    {
        $user = $this->where('email', $email)
            ->first();

        $token = $user->createToken('Login token');
        $user->token = $token->plainTextToken;

        return $user;
    }
}
