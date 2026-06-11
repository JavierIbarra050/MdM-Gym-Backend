<?php

namespace Src\Domain\Entities\Workout;

class Exercise
{
    private int $id;

    private string $name;

    private string $muscleGroup;

    public function __construct(int $id, string $name, string $muscleGroup)
    {
        $this->id = $id;
        $this->name = $name;
        $this->muscleGroup = $muscleGroup;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMuscleGroup(): string
    {
        return $this->muscleGroup;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'muscle_group' => $this->muscleGroup,
        ];
    }
}
