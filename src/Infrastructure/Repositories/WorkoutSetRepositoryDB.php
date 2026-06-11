<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Workout\WorkoutSet;
use Src\Domain\Repositories\IWorkoutSetRepository;

class WorkoutSetRepositoryDB implements IWorkoutSetRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function findById(int $id): ?WorkoutSet
    {
        $setData = DB::selectOne('SELECT * FROM workout_sets WHERE id = ? LIMIT 1', [$id]);

        if (! $setData) {
            return null;
        }

        return new WorkoutSet(
            (int) $setData->id,
            (string) $setData->exercise_name,
            (float) $setData->weight,
            (int) $setData->reps,
            (bool) $setData->is_completed
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function save(WorkoutSet $set): void
    {
        DB::update(
            'UPDATE workout_sets SET weight = ?, reps = ?, is_completed = ?, updated_at = ? WHERE id = ?',
            [
                $set->getWeight(),
                $set->getReps(),
                $set->isCompleted() ? 1 : 0,
                now(),
                $set->getId(),
            ]
        );
    }
}
