<?php

namespace Src\Infrastructure\Repositories;

use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Workout\Workout;
use Src\Domain\Entities\Workout\WorkoutSet;
use Src\Domain\Repositories\IWorkoutRepository;

class WorkoutRepositoryDB implements IWorkoutRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getLatestCompletedWorkouts(int $limit): array
    {
        $workoutsData = DB::select(
            'SELECT w.id, u.name as user_name, w.date 
             FROM workouts w 
             JOIN users u ON w.user_id = u.id 
             WHERE w.status = ? 
             ORDER BY w.date DESC 
             LIMIT ?',
            ['COMPLETED', $limit]
        );

        return array_map(function ($workout) {
            return [
                'id' => $workout->id,
                'user' => $workout->user_name,
                'date' => $workout->date,
            ];
        }, $workoutsData);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function findActiveByUserId(int $userId): ?Workout
    {
        $workoutData = DB::selectOne(
            'SELECT * FROM workouts WHERE user_id = ? AND status = ? LIMIT 1',
            [$userId, 'IN_PROGRESS']
        );

        if (! $workoutData) {
            return null;
        }

        $setsData = DB::select(
            'SELECT * FROM workout_sets WHERE workout_id = ? ORDER BY id ASC',
            [$workoutData->id]
        );

        $sets = array_map(function ($setData) {
            return new WorkoutSet(
                (int) $setData->id,
                (string) $setData->exercise_name,
                (float) $setData->weight,
                (int) $setData->reps,
                (bool) $setData->is_completed
            );
        }, $setsData);

        return new Workout(
            (int) $workoutData->id,
            (int) $workoutData->user_id,
            (string) $workoutData->status,
            new DateTimeImmutable($workoutData->date),
            $workoutData->start_time ? new DateTimeImmutable($workoutData->start_time) : null,
            $workoutData->end_time ? new DateTimeImmutable($workoutData->end_time) : null,
            $sets
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function save(Workout $workout): void
    {
        $exists = DB::selectOne('SELECT id FROM workouts WHERE id = ?', [$workout->getId()]);

        if ($exists) {
            DB::update(
                'UPDATE workouts SET status = ?, start_time = ?, end_time = ?, updated_at = ? WHERE id = ?',
                [
                    $workout->getStatus(),
                    $workout->getStartTime() ? $workout->getStartTime()->format('Y-m-d H:i:s') : null,
                    $workout->getEndTime() ? $workout->getEndTime()->format('Y-m-d H:i:s') : null,
                    now(),
                    $workout->getId(),
                ]
            );
        } else {
            DB::insert(
                'INSERT INTO workouts (id, user_id, status, date, start_time, end_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $workout->getId(),
                    $workout->getUserId(),
                    $workout->getStatus(),
                    $workout->getDate()->format('Y-m-d H:i:s'),
                    $workout->getStartTime() ? $workout->getStartTime()->format('Y-m-d H:i:s') : null,
                    $workout->getEndTime() ? $workout->getEndTime()->format('Y-m-d H:i:s') : null,
                    now(),
                    now(),
                ]
            );
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function saveSet(int $workoutId, WorkoutSet $set): void
    {
        DB::insert(
            'INSERT INTO workout_sets (workout_id, exercise_name, weight, reps, is_completed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $workoutId,
                $set->getExerciseName(),
                $set->getWeight(),
                $set->getReps(),
                $set->isCompleted() ? 1 : 0,
                now(),
                now(),
            ]
        );
    }
}
