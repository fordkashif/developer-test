<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Route::post('/users/comment/add', [AchievementsController::class, 'commentRequest']);

Route::post('/users/lesson-watched/add', [AchievementsController::class, 'lessonWatchedRequest']);