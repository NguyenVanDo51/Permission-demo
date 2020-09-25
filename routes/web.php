<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('dashboard', 'users');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['auth:sanctum', 'verified'], function () {

    Route::get('users', [UserController::class, 'index'])
        ->middleware('can:users.index')->name('users.index');

    Route::get('profile/{user}', [UserController::class, 'show'])
        ->middleware('can:users.show')->name('users.show');

    Route::post('users/{user}/permission', [UserController::class, 'store'])
        ->middleware('can:users.permissions.edit')->name('users.permissions.edit');

    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('can:roles.index')->name('roles.index');

    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])
        ->middleware('can:roles.edit')->name('roles.edit');

    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->middleware('roles.update')->name('roles.update');

    Route::get('roles/create', [RoleController::class, 'create'])
        ->middleware('can:roles.create')->name('roles.create');

    Route::get('roles/{role}/delete', [RoleController::class, 'destroy'])
        ->middleware('can:roles.destroy')->name('roles.destroy');

    Route::get('permissions', [PermissionController::class, 'index'])
        ->middleware('can:permissions.index')->name('permissions.index');

    Route::post('permissions', [PermissionController::class, 'store'])
        ->middleware('permissions.store')->name('permissions.store');

    Route::get('permissions/{permission}/delete', [PermissionController::class, 'destroy'])
        ->middleware('can:permissions.destroy')->name('permissions.destroy');

    Route::get('posts', [PostController::class, 'index'])
        ->middleware('can:posts.index')->name('posts.index');

    Route::get('posts/{post}', [PostController::class, 'show'])
        ->middleware('can:posts.show')->name('posts.show');


    Route::get('/comments', [CommentController::class, 'index'])->name('posts.comments.index');

    Route::get('comment/{comment}', [CommentController::class, 'show'])->name('comments.show');

    Route::get('test', [UserController::class, 'test'])->name('test');
});

