<?php

namespace Src\Domain\Entities\Workout;

class WorkoutSet
{
    private int $id;

    private string $exerciseName;

    private int $weight;

    private int $reps;

    public function __construct(
        int $id,
        string $exerciseName,
        int $weight,
        int $reps)
    {
        $this->id = $id;
        $this->exerciseName = $exerciseName;
        $this->weight = $weight;
        $this->reps = $reps;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExerciseName(): string
    {
        return $this->exerciseName;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getReps(): int
    {
        return $this->reps;
    }
}
