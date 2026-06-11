<?php

namespace Src\Domain\Entities\Workout;

use Exception;

class WorkoutSet
{
    private int $id;

    private string $exerciseName;

    private float $weight;

    private int $reps;

    private bool $isCompleted;

    public function __construct(
        int $id,
        string $exerciseName,
        float $weight,
        int $reps,
        bool $isCompleted = false
    ) {
        $this->id = $id;
        $this->exerciseName = $exerciseName;
        $this->weight = $weight;
        $this->reps = $reps;
        $this->isCompleted = $isCompleted;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExerciseName(): string
    {
        return $this->exerciseName;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getReps(): int
    {
        return $this->reps;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @throws Exception
     */
    public function updateValues(float $weight, int $reps): void
    {
        if ($weight < 0 || $reps < 0) {
            throw new Exception('Los kilos y las repeticiones no pueden ser valores negativos.');
        }

        $this->weight = $weight;
        $this->reps = $reps;
    }

    public function markAsComplete(): void
    {
        $this->isCompleted = true;
    }

    public function markAsIncomplete(): void
    {
        $this->isCompleted = false;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'exercise_name' => $this->exerciseName,
            'weight' => $this->weight,
            'reps' => $this->reps,
            'is_completed' => $this->isCompleted,
        ];
    }
}
