<?php

namespace Src\Domain\Entities\Workout;

use DateTimeImmutable;
use Exception;

class Workout
{
    private int $id;

    private int $userId;

    private string $status;

    private DateTimeImmutable $date;

    private ?DateTimeImmutable $startTime;

    private ?DateTimeImmutable $endTime;

    /** @var WorkoutSet[] */
    private array $sets;

    public function __construct(
        int $id,
        int $userId,
        string $status,
        DateTimeImmutable $date,
        ?DateTimeImmutable $startTime = null,
        ?DateTimeImmutable $endTime = null,
        array $sets = []
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->status = $status;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): ?DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getSets(): array
    {
        return $this->sets;
    }

    /**
     * @throws Exception
     */
    public function finish(): void
    {
        if ($this->status === 'COMPLETED') {
            throw new Exception('El entrenamiento ya ha sido finalizado.');
        }

        $this->status = 'COMPLETED';
        $this->endTime = new DateTimeImmutable;
    }

    public function addSet(WorkoutSet $set): void
    {
        $this->sets[] = $set;
    }

    public function addExercise(string $exerciseName): void
    {
        // Al añadir un ejercicio, simplemente añadimos la primera serie con valores a cero
        // El ID es 0 porque es una entidad nueva que aún no está en la DB
        $this->addSet(new WorkoutSet(0, $exerciseName, 0.0, 0));
    }

    public function addSetToExercise(string $exerciseName): void
    {
        // Buscamos si ya existe el ejercicio para copiar el nombre exacto si fuera necesario
        // aunque aquí simplemente añadimos otra serie con el mismo nombre.
        $this->addSet(new WorkoutSet(0, $exerciseName, 0.0, 0));
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'status' => $this->status,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'start_time' => $this->startTime ? $this->startTime->format('Y-m-d H:i:s') : null,
            'end_time' => $this->endTime ? $this->endTime->format('Y-m-d H:i:s') : null,
            'sets' => array_map(fn ($set) => $set->toArray(), $this->sets),
            'total_volume' => $this->getTotalVolume(),
        ];
    }
}
