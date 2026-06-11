<?php

namespace Src\Domain\Entities\Leaderboard;

class Leaderboard
{
    private array $usuariosLeaderboard;

    public function __construct(array $usuariosLeaderboard = [])
    {
        $this->usuariosLeaderboard = $usuariosLeaderboard;
    }

    public function getRows(): array
    {
        return $this->usuariosLeaderboard;
    }

    public function getLeader(): ?UsuarioLeaderboard
    {
        return $this->usuariosLeaderboard[0] ?? null;
    }
}
