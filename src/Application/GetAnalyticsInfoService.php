<?php

namespace Src\Application;

use Src\Domain\Repositories\IAnalyticsRepository;

class GetAnalyticsInfoService
{
    private IAnalyticsRepository $repository;

    public function __construct(IAnalyticsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $userId, ?string $exerciseName = null): array
    {
        if ($exerciseName) {
            $stats = $this->repository->getExerciseStats($userId, $exerciseName);

            return $stats ? $stats->toArray() : [];
        }

        $allStats = $this->repository->getAllExercisesStats($userId);

        return array_map(fn ($stat) => $stat->toArray(), $allStats);
    }
}
