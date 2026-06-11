<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\GetAnalyticsInfoService;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsController extends Controller
{
    private GetAnalyticsInfoService $service;

    public function __construct(GetAnalyticsInfoService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $userId = (int) $request->query('user_id'); // En un entorno real, vendría del auth
            $exerciseName = $request->query('exercise_name');

            if ($userId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'El ID de usuario es obligatorio y debe ser válido.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $data = $this->service->execute($userId, $exerciseName);

            return response()->json([
                'success' => true,
                'data' => $data,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las analíticas: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
