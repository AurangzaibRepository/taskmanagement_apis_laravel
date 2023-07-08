<?php

use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\TeamsController;
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

Route::get('categories/all', [CategoriesController::class, 'all']);
Route::post('categories/change-status/{id}/{status}', [CategoriesController::class, 'changeStatus']);
Route::get('categories/listing/{pageNumber}/{name?}', [CategoriesController::class, 'listing']);
Route::resource('categories', CategoriesController::class);

Route::get('teams/all', [TeamsController::class, 'all']);
Route::get('teams/listing/{pageNumber}/{code?}/{name?}', [TeamsController::class, 'listing']);
Route::resource('teams', TeamsController::class);

Route::get('projects/all/{teamId}', [ProjectsController::class, 'all']);
Route::get('projects/listing/{pageNumber}/{code?}/{name?}/{team_id?}', [ProjectsController::class, 'listing']);
Route::resource('projects', ProjectsController::class);
