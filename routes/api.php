<?php

use App\Http\Controllers\ChallengeContributionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', DashboardController::class);
Route::post('/challenges/{id}/contribute', ChallengeContributionController::class);
