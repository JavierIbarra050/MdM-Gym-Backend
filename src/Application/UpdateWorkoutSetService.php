<?php

namespace Src\Application;

use Exception;
use Src\Domain\Repositories\IWorkoutSetRepository;

class UpdateWorkoutSetService
{
    private IWorkoutSetRepository $repository;

    public function __construct(IWorkoutSetRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $setId, float $weight, int $reps, bool $isCompleted): void
    {
        $set = $this->repository->findById($setId);

        if (! $set) {
            throw new Exception("La serie con ID {$setId} no existe.");
        }

        $set->updateValues($weight, $reps);

        if ($isCompleted) {
            $set->markAsComplete();
        } else {
            $set->markAsIncomplete();
        }

        $this->repository->save($set);
    }
}
