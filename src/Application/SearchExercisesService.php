<?php

namespace Src\Application;

use Src\Domain\Repositories\IExerciseRepository;

class SearchExercisesService
{
    private IExerciseRepository $repository;

    public function __construct(IExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(?string $query = null, ?string $muscleGroup = null): array
    {
        $exercises = $this->repository->search($query, $muscleGroup);

        return array_map(fn ($exercise) => $exercise->toArray(), $exercises);
    }
}
