<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Workout\Workout;
use Src\Domain\Entities\Workout\WorkoutSet;

interface IWorkoutRepository
{
    public function getLatestCompletedWorkouts(int $limit): array;

    public function findActiveByUserId(int $userId): ?Workout;

    public function save(Workout $workout): void;

    public function saveSet(int $workoutId, WorkoutSet $set): void;
}
