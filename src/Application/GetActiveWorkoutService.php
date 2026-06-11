<?php

namespace Src\Application;

use Src\Domain\Repositories\IWorkoutRepository;

class GetActiveWorkoutService
{
    private IWorkoutRepository $repository;

    public function __construct(IWorkoutRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $userId): ?array
    {
        $activeWorkout = $this->repository->findActiveByUserId($userId);

        if (!$activeWorkout) {
            return null;
        }

        return $activeWorkout->toArray();
    }
}
