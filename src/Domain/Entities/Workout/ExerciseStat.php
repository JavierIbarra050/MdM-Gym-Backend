<?php

namespace Src\Domain\Entities\Workout;

class ExerciseStat
{
    private string $exerciseName;

    private float $maxWeight;

    private int $maxReps;

    private float $totalVolume;

    private float $estimated1RM;

    public function __construct(
        string $exerciseName,
        float $maxWeight,
        int $maxReps,
        float $totalVolume,
        float $estimated1RM
    ) {
        $this->exerciseName = $exerciseName;
        $this->maxWeight = $maxWeight;
        $this->maxReps = $maxReps;
        $this->totalVolume = $totalVolume;
        $this->estimated1RM = $estimated1RM;
    }

    public function getExerciseName(): string
    {
        return $this->exerciseName;
    }

    public function getMaxWeight(): float
    {
        return $this->maxWeight;
    }

    public function getMaxReps(): int
    {
        return $this->maxReps;
    }

    public function getTotalVolume(): float
    {
        return $this->totalVolume;
    }

    public function getEstimated1RM(): float
    {
        return $this->estimated1RM;
    }

    public function toArray(): array
    {
        return [
            'exercise_name' => $this->exerciseName,
            'max_weight' => $this->maxWeight,
            'max_reps' => $this->maxReps,
            'total_volume' => $this->totalVolume,
            'estimated_1rm' => $this->estimated1RM,
        ];
    }
}
