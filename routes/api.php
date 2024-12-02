<?php



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

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Route to get all tasks of the authenticated user
    Route::get('/tasks', [TaskController::class, 'index']);

    // Route to create a new task for the authenticated user
    Route::post('/tasks', [TaskController::class, 'store']);

    // Route to delete a task by ID
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});
