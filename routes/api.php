<?php

use App\Http\Controllers\ActiveWorkoutController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChallengeContributionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', DashboardController::class);
Route::post('/challenges/{id}/contribute', ChallengeContributionController::class);
Route::get('/analytics', AnalyticsController::class);
Route::get('/exercises', ExerciseSearchController::class);
Route::get('/workouts/active', ActiveWorkoutController::class);
