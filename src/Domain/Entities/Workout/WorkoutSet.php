<?php

namespace Src\Domain\Entities\Workout;

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
}
