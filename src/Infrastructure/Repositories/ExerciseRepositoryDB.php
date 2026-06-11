<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Workout\Exercise;
use Src\Domain\Repositories\IExerciseRepository;

class ExerciseRepositoryDB implements IExerciseRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function search(?string $query = null, ?string $muscleGroup = null): array
    {
        $sql = 'SELECT * FROM exercises WHERE 1=1';
        $bindings = [];

        if ($query) {
            $sql .= ' AND name LIKE ?';
            $bindings[] = '%'.$query.'%';
        }

        if ($muscleGroup) {
            $sql .= ' AND muscle_group = ?';
            $bindings[] = $muscleGroup;
        }

        $sql .= ' ORDER BY name ASC';

        $exercisesData = DB::select($sql, $bindings);

        return array_map(function ($data) {
            return new Exercise(
                (int) $data->id,
                (string) $data->name,
                (string) $data->muscle_group
            );
        }, $exercisesData);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function findById(int $id): ?Exercise
    {
        $exerciseData = DB::selectOne('SELECT * FROM exercises WHERE id = ? LIMIT 1', [$id]);

        if (! $exerciseData) {
            return null;
        }

        return new Exercise(
            (int) $exerciseData->id,
            (string) $exerciseData->name,
            (string) $exerciseData->muscle_group
        );
    }
}
