<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Workout\WorkoutSet;

interface IWorkoutSetRepository
{
    public function findById(int $id): ?WorkoutSet;

    public function save(WorkoutSet $set): void;
}
