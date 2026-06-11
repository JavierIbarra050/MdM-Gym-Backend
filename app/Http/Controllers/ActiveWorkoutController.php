<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\GetActiveWorkoutService;
use Symfony\Component\HttpFoundation\Response;

class ActiveWorkoutController extends Controller
{
    private GetActiveWorkoutService $service;

    public function __construct(GetActiveWorkoutService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $userId = (int) $request->query('user_id'); // En un entorno real, vendría del auth

            if ($userId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'El ID de usuario es obligatorio.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $data = $this->service->execute($userId);

            return response()->json([
                'success' => true,
                'data' => $data,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recuperar el entrenamiento activo: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
