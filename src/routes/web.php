<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;

Route::get('/',[TodoController::class, 'index']); 
Route::post('/todos',[TodoController::class, 'store']);
Route::patch('/todos/update', [TodoController::class, 'update']);
Route::delete('/todos/delete', [TodoController::class, 'destroy']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories',[CategoryController::class, 'store']);
Route::patch('/categories/update',[CategoryController::class, 'update']);
Route::delete('/categories/delete',[CategoryController::class, 'destroy']);