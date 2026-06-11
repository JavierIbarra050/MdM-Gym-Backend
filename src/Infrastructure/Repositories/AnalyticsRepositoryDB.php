<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Workout\ExerciseStat;
use Src\Domain\Repositories\IAnalyticsRepository;

class AnalyticsRepositoryDB implements IAnalyticsRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getExerciseStats(int $userId, string $exerciseName): ?ExerciseStat
    {
        $statsData = DB::selectOne(
            'SELECT 
                exercise_name,
                MAX(weight) as max_weight,
                MAX(reps) as max_reps,
                SUM(weight * reps) as total_volume,
                MAX(weight * (1 + (reps / 30.0))) as estimated_1rm
             FROM workout_sets ws
             JOIN workouts w ON ws.workout_id = w.id
             WHERE w.user_id = ? AND ws.exercise_name = ? AND ws.is_completed = 1
             GROUP BY exercise_name',
            [$userId, $exerciseName]
        );

        if (! $statsData) {
            return null;
        }

        return new ExerciseStat(
            (string) $statsData->exercise_name,
            (float) $statsData->max_weight,
            (int) $statsData->max_reps,
            (float) $statsData->total_volume,
            (float) $statsData->estimated_1rm
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getAllExercisesStats(int $userId): array
    {
        $allStatsData = DB::select(
            'SELECT 
                exercise_name,
                MAX(weight) as max_weight,
                MAX(reps) as max_reps,
                SUM(weight * reps) as total_volume,
                MAX(weight * (1 + (reps / 30.0))) as estimated_1rm
             FROM workout_sets ws
             JOIN workouts w ON ws.workout_id = w.id
             WHERE w.user_id = ? AND ws.is_completed = 1
             GROUP BY exercise_name',
            [$userId]
        );

        return array_map(function ($data) {
            return new ExerciseStat(
                (string) $data->exercise_name,
                (float) $data->max_weight,
                (int) $data->max_reps,
                (float) $data->total_volume,
                (float) $data->estimated_1rm
            );
        }, $allStatsData);
    }
}
