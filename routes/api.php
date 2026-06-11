<?php

use App\Http\Controllers\ActiveWorkoutController;
use App\Http\Controllers\AddExerciseToWorkoutController;
use App\Http\Controllers\AddSetToWorkoutController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChallengeContributionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseSearchController;
use App\Http\Controllers\UpdateWorkoutSetController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', DashboardController::class);
Route::post('/challenges/{id}/contribute', ChallengeContributionController::class);
Route::get('/analytics', AnalyticsController::class);
Route::get('/exercises', ExerciseSearchController::class);

Route::prefix('workouts')->group(function () {
    Route::get('/active', ActiveWorkoutController::class);
    Route::post('/active/exercises', AddExerciseToWorkoutController::class);
    Route::post('/active/sets', AddSetToWorkoutController::class);
    Route::put('/sets/{id}', UpdateWorkoutSetController::class);
});
