<?php

namespace Src\Application;

use Exception;
use Src\Domain\Repositories\IChallengeRepository;

class PostChallengeContributionService
{
    private IChallengeRepository $repository;

    public function __construct(IChallengeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $challengeId, int $userId, float $weight): void
    {
        $challenge = $this->repository->findById($challengeId);

        if (! $challenge) {
            throw new Exception("El reto con ID {$challengeId} no existe.");
        }

        if ($challenge->getStatus() !== 'ACTIVE') {
            throw new Exception('No se pueden añadir contribuciones a un reto que no esté activo.');
        }

        $challenge->addContribution($weight);

        $this->repository->updateChallenge($challenge);

        $this->repository->saveContribution($challengeId, $userId, $weight);
    }
}
