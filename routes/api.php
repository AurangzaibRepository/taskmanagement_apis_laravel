<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\DepartmentsController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\TasksController;
use App\Http\Controllers\API\TeamsController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::get('categories/all', [CategoriesController::class, 'all']);
Route::post('categories/change-status/{id}/{status}', [CategoriesController::class, 'changeStatus']);
Route::post('categories/listing', [CategoriesController::class, 'listing']);
Route::resource('categories', CategoriesController::class);

Route::get('teams/all', [TeamsController::class, 'all']);
Route::post('teams/listing', [TeamsController::class, 'listing']);
Route::resource('teams', TeamsController::class);

Route::get('projects/all/{teamId}', [ProjectsController::class, 'all']);
Route::post('projects/listing', [ProjectsController::class, 'listing']);
Route::resource('projects', ProjectsController::class);

Route::get('tasks/all/{projectId}', [TasksController::class, 'all']);
Route::post('tasks/listing', [TasksController::class, 'listing']);
Route::resource('tasks', TasksController::class);

Route::get('departments/all/{teamId}', [DepartmentsController::class, 'all']);
Route::post('departments/listing', [DepartmentsController::class, 'listing']);
Route::resource('departments', DepartmentsController::class);

Route::get('users/all/{teamId}/{departmentId}', [UsersController::class, 'all']);
Route::post('users/listing', [UsersController::class, 'listing']);
Route::resource('users', UsersController::class);
