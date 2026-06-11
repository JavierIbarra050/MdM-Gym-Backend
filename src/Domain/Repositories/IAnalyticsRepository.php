<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Workout\ExerciseStat;

interface IAnalyticsRepository
{
    public function getExerciseStats(int $userId, string $exerciseName): ?ExerciseStat;

    /**
     * @return ExerciseStat[]
     */
    public function getAllExercisesStats(int $userId): array;
}
