<?php

namespace Src\Domain\Dashboard\Leaderboard;

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

    /**
     * Lógica de dominio: por ejemplo, obtener el espartano que va ganando
     */
    public function getLeader(): ?UsuarioLeaderboard
    {
        return $this->usuariosLeaderboard[0] ?? null;
    }
}
