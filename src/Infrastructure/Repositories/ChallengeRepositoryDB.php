<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Domain\Entities\Challenge\Challenge;
use Src\Domain\Entities\Leaderboard\Leaderboard;
use Src\Domain\Repositories\IChallengeRepository;

class ChallengeRepositoryDB implements IChallengeRepository
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function findById(int $id): ?Challenge
    {
        $challengeData = DB::selectOne('SELECT * FROM challenges WHERE id = ? LIMIT 1', [$id]);

        if (! $challengeData) {
            return null;
        }

        return new Challenge(
            (int) $challengeData->id,
            (string) $challengeData->title,
            (string) $challengeData->description,
            (float) $challengeData->current_weight,
            (float) $challengeData->objective_weight,
            (string) $challengeData->status
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function findActiveChallenge(): ?Challenge
    {
        $challengeData = DB::selectOne('SELECT * FROM challenges WHERE status = ? LIMIT 1', ['ACTIVE']);

        if (! $challengeData) {
            return null;
        }

        return new Challenge(
            (int) $challengeData->id,
            (string) $challengeData->title,
            (string) $challengeData->description,
            (float) $challengeData->current_weight,
            (float) $challengeData->objective_weight,
            (string) $challengeData->status
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function updateChallenge(Challenge $challenge): void
    {
        DB::update(
            'UPDATE challenges SET current_weight = ?, status = ? WHERE id = ?',
            [
                $challenge->getCurrentWeight(),
                $challenge->getStatus(),
                $challenge->getId(),
            ]
        );
    }

    public function saveContribution(int $challengeId, int $userId, float $weight): void
    {
        // Se implementará en la sub-issue #63
    }

    public function getLeaderboard(int $challengeId, int $limit): Leaderboard
    {
        return new Leaderboard([]);
    }
}
