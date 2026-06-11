<?php

namespace Src\Domain\Entities\Challenge;

class Challenge
{
    private int $id;

    private string $title;

    private string $description;

    private float $currentWeight;

    private float $objectiveWeight;

    private string $status;

    public function __construct(
        int $id,
        string $title,
        string $description,
        float $currentWeight,
        float $objectiveWeight,
        string $status = 'ACTIVE'
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->currentWeight = $currentWeight;
        $this->objectiveWeight = $objectiveWeight;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCurrentWeight(): float
    {
        return $this->currentWeight;
    }

    public function getObjectiveWeight(): float
    {
        return $this->objectiveWeight;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCurrentPercentage(): float
    {
        if ($this->objectiveWeight === 0.0) {
            return 0.0;
        }

        $percentage = ($this->currentWeight / $this->objectiveWeight) * 100;

        return round($percentage, 1);
    }

    public function addContribution(float $weight): void
    {
        if ($this->status === 'COMPLETED') {
            return;
        }

        $this->currentWeight += $weight;

        if ($this->currentWeight >= $this->objectiveWeight) {
            $this->currentWeight = $this->objectiveWeight;
            $this->status = 'COMPLETED';
        }
    }
}
