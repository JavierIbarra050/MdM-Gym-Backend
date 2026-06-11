<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\SearchExercisesService;
use Symfony\Component\HttpFoundation\Response;

class ExerciseSearchController extends Controller
{
    private SearchExercisesService $service;

    public function __construct(SearchExercisesService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = $request->query('query');
            $muscleGroup = $request->query('muscle_group');

            $data = $this->service->execute($query, $muscleGroup);

            return response()->json([
                'success' => true,
                'data' => $data,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar ejercicios: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
