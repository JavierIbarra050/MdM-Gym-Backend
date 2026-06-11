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

    public function getLeaderboard(int $challengeId, int $limit): Leaderboard
    {
        // Por ahora devolvemos un leaderboard vacío hasta tener la lógica de contribuciones
        return new Leaderboard([]);
    }
}
