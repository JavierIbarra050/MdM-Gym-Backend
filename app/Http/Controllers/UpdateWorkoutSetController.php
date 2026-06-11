<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\UpdateWorkoutSetService;
use Symfony\Component\HttpFoundation\Response;

class UpdateWorkoutSetController extends Controller
{
    private UpdateWorkoutSetService $service;

    public function __construct(UpdateWorkoutSetService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'weight' => 'required|numeric|min:0',
                'reps' => 'required|integer|min:0',
                'is_completed' => 'required|boolean',
            ]);

            $this->service->execute(
                $id,
                (float) $request->input('weight'),
                (int) $request->input('reps'),
                (bool) $request->input('is_completed')
            );

            return response()->json([
                'success' => true,
                'message' => 'Serie actualizada correctamente.',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la serie: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
