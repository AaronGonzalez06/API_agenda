<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/api/task/list', 'TaskController@listToday');
Route::get('task/list', [TaskController::class, 'listToday']);
Route::post('task/add', [TaskController::class, 'addTask']);
Route::post('task/searchDay', [TaskController::class, 'searchDay']);
Route::post('task/searchDayEarring', [TaskController::class, 'searchDayEarring']);
Route::post('task/searchDayFinished', [TaskController::class, 'searchDayFinished']);
Route::post('task/searchDayTwo', [TaskController::class, 'searchDayTwo']);
Route::get('task/nowTaksFinished', [TaskController::class, 'nowTaksFinished']);
Route::get('task/nowTaksEarring', [TaskController::class, 'nowTaksEarring']);
Route::get('task/taskId/{id}', [TaskController::class, 'taskId']);
Route::get('task/taksEarring', [TaskController::class, 'taksEarring']);
Route::get('task/taksNext', [TaskController::class, 'taksNext']);
Route::get('task/dayTasks/{day}', [TaskController::class, 'dayTasks']);
Route::get('task/finishedTask/{id}', [TaskController::class, 'finishedTask']);
Route::post('task/updatedTask', [TaskController::class, 'updatedTask']);