<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\GetDashboardInfoService;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    private GetDashboardInfoService $service;

    public function __construct(GetDashboardInfoService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $data = $this->service->getInfo();

            return response()->json([
                'success' => true,
                'data' => $data,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la informacion del dashboard: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
