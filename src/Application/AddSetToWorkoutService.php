<?php

namespace Src\Application;

use Exception;
use Src\Domain\Repositories\IExerciseRepository;
use Src\Domain\Repositories\IWorkoutRepository;

class AddSetToWorkoutService
{
    private IWorkoutRepository $workoutRepository;

    private IExerciseRepository $exerciseRepository;

    public function __construct(
        IWorkoutRepository $workoutRepository,
        IExerciseRepository $exerciseRepository
    ) {
        $this->workoutRepository = $workoutRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $exerciseId): void
    {
        $workout = $this->workoutRepository->findActiveByUserId($userId);

        if (! $workout) {
            throw new Exception('No hay un entrenamiento activo para el usuario.');
        }

        $exercise = $this->exerciseRepository->findById($exerciseId);

        if (! $exercise) {
            throw new Exception("El ejercicio con ID {$exerciseId} no existe.");
        }

        $workout->addSetToExercise($exercise->getName());

        $sets = $workout->getSets();
        $newSet = end($sets);

        $this->workoutRepository->saveSet($workout->getId(), $newSet);
    }
}
