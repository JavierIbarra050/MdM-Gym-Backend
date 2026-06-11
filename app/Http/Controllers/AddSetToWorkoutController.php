<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\AddSetToWorkoutService;
use Symfony\Component\HttpFoundation\Response;

class AddSetToWorkoutController extends Controller
{
    private AddSetToWorkoutService $service;

    public function __construct(AddSetToWorkoutService $service)
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
                'message' => 'Serie añadida al ejercicio correctamente.',
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al añadir la serie: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
