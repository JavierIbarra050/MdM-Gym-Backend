<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\PostChallengeContributionService;
use Symfony\Component\HttpFoundation\Response;

class ChallengeContributionController extends Controller
{
    private PostChallengeContributionService $service;

    public function __construct(PostChallengeContributionService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'weight' => 'required|numeric|min:0.1',
            ]);

            $this->service->execute(
                $id,
                (int) $request->input('user_id'),
                (float) $request->input('weight')
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribución registrada exitosamente.',
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la contribución: '.$e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
