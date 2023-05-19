<?php

use App\Http\Controllers\Api\{ToDoController, UsersController};
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


// TODO: Hacer que la autenticacion pase por sanctum, como? no se 
Route::middleware('web', 'auth:web')->group(function () {
    Route::delete('/todos', [ToDoController::class, 'destroyDones']);
    Route::patch('/todos/{id}/done', [ToDoController::class, 'updateDoneAt']);

    Route::apiResources([
        '/todos'    => ToDoController::class,
        '/users'    =>  UsersController::class
    ]);
});
