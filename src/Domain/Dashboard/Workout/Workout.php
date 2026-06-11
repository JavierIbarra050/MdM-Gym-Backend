<?php

namespace Src\Domain\Dashboard\Workout;

use DateTimeImmutable;

class Workout
{
    private int $id;

    private int $userId;

    private string $status;

    private DateTimeImmutable $date;

    /** @var WorkoutSet[] */
    private array $sets;

    public function __construct(
        int $id,
        int $userId,
        string $status,
        DateTimeImmutable $date,
        array $sets = []
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->status = $status;
        $this->date = $date;
        $this->sets = $sets;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getSets(): array
    {
        return $this->sets;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTotalVolume(): float
    {
        $volume = 0.0;
        foreach ($this->sets as $set) {
            if ($set->isCompleted()) {
                $volume += $set->getWeight() * $set->getReps();
            }
        }

        return $volume;
    }
}
