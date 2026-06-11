<?php

namespace Src\Application;

use Src\Domain\Repositories\IChallengeRepository;
use Src\Domain\Repositories\IWorkoutRepository;

class GetDashboardInfoService
{
    private IChallengeRepository $challengeRepository;

    private IWorkoutRepository $workoutRepository;

    public function __construct(
        IChallengeRepository $challengeRepository,
        IWorkoutRepository $workoutRepository
    ) {
        $this->challengeRepository = $challengeRepository;
        $this->workoutRepository = $workoutRepository;
    }

    public function getInfo(): array
    {
        $activeChallenge = $this->challengeRepository->findActiveChallenge();

        $leaderboard = null;
        if ($activeChallenge !== null) {
            $leaderboard = $this->challengeRepository->getLeaderboard($activeChallenge->getId(), 3);
        }

        $feedWorkouts = $this->workoutRepository->getLatestCompletedWorkouts(10);

        return [
            'challenge' => $activeChallenge ? [
                'title' => $activeChallenge->getTitle(),
                'description' => $activeChallenge->getDescription(),
                'percentage' => $activeChallenge->getCurrentPercentage(),
            ] : null,
            'leaderboard' => $leaderboard ? $leaderboard->getRows() : [],
            'feed' => $feedWorkouts,
        ];
    }
}
