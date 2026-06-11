<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Challenge\Challenge;
use Src\Domain\Entities\Leaderboard\Leaderboard;

interface IChallengeRepository
{
    public function findActiveChallenge(): ?Challenge;

    public function updateChallenge(Challenge $challenge): void;

    public function getLeaderboard(int $challengeId, int $limit): Leaderboard;
}
