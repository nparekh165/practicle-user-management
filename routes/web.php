<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserApiController;

Route::get('/', fn () => redirect()->route('users.index'));

Route::resource('users', UserController::class);

Route::get('/api/users/{user}', [UserApiController::class, 'show']);