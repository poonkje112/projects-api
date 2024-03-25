<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/members', [MemberController::class, 'index']);
Route::get('/members/{member}', [MemberController::class, 'show']);
Route::post('members', [MemberController::class, 'store']);
Route::put('members/{member}', [MemberController::class, 'update']);
Route::delete('members/{member}', [MemberController::class, 'destroy']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{project:slug}', [ProjectController::class, 'update']);
Route::delete('/projects/{project:slug}', [ProjectController::class, 'destroy']);
Route::post('/projects/{project:slug}/members/{member}', [ProjectController::class, 'addMember']);
Route::delete('/projects/{project:slug}/members/{member}', [ProjectController::class, 'removeMember']);
Route::post('/projects/{project:slug}/tags/{tag}', [ProjectController::class, 'addTag']);
Route::delete('/projects/{project:slug}/tags/{tag}', [ProjectController::class, 'removeTag']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);
Route::post('/tags', [TagController::class, 'store']);
Route::put('/tags/{tag}', [TagController::class, 'update']);
Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

Route::get('/images/{id}', [ImageController::class, 'show']);
Route::get('/images/project/{project:slug}', [ImageController::class, 'showProjectCollection']);
Route::post('/images', [ImageController::class, 'store']);
Route::put('/images/{id}', [ImageController::class, 'update']);
Route::delete('/images/{id}', [ImageController::class, 'destroy']);