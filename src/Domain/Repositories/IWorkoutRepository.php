<?php

namespace Src\Domain\Repositories;

interface IWorkoutRepository
{
    public function getLatestCompletedWorkouts(int $limit): array;
}
