<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Repositories\IAnalyticsRepository;
use Src\Domain\Repositories\IChallengeRepository;
use Src\Domain\Repositories\IWorkoutRepository;
use Src\Infrastructure\Repositories\AnalyticsRepositoryDB;
use Src\Infrastructure\Repositories\ChallengeRepositoryDB;
use Src\Infrastructure\Repositories\WorkoutRepositoryDB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            IChallengeRepository::class,
            ChallengeRepositoryDB::class
        );

        $this->app->bind(
            IWorkoutRepository::class,
            WorkoutRepositoryDB::class
        );

        $this->app->bind(
            IAnalyticsRepository::class,
            AnalyticsRepositoryDB::class
        );
    }

    public function boot(): void
    {
        //
    }
}
