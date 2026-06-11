<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Workout\Exercise;

interface IExerciseRepository
{
    /**
     * @return Exercise[]
     */
    public function search(?string $query = null, ?string $muscleGroup = null): array;

    public function findById(int $id): ?Exercise;
}
