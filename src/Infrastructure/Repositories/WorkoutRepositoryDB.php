<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Workout\Workout;
use Src\Domain\Repositories\IWorkoutRepository;

class WorkoutRepositoryDB implements IWorkoutRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getLatestCompletedWorkouts(int $limit): array
    {
        $workoutsData = DB::select(
            'SELECT w.id, u.name as user_name, w.date 
             FROM workouts w 
             JOIN users u ON w.user_id = u.id 
             WHERE w.status = ? 
             ORDER BY w.date DESC 
             LIMIT ?',
            ['COMPLETED', $limit]
        );

        return array_map(function ($workout) {
            return [
                'id' => $workout->id,
                'user' => $workout->user_name,
                'date' => $workout->date,
            ];
        }, $workoutsData);
    }

    public function findActiveByUserId(int $userId): ?Workout
    {
        // Se implementará en la issue #31
        return null;
    }

    public function save(Workout $workout): void
    {
        // Se implementará en la issue #31
    }
}
