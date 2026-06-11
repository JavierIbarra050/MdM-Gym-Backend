<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\AddExerciseToWorkoutService;
use Symfony\Component\HttpFoundation\Response;

class AddExerciseToWorkoutController extends Controller
{
    private AddExerciseToWorkoutService $service;

    public function __construct(AddExerciseToWorkoutService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'exercise_id' => 'required|integer',
            ]);

            $this->service->execute(
                (int) $request->input('user_id'),
                (int) $request->input('exercise_id')
            );

            return response()->json([
                'success' => true,
                'message' => 'Ejercicio añadido al entrenamiento correctamente.',
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al añadir el ejercicio: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
