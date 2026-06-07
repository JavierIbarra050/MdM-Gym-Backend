<?php

namespace Src\Domain;

class UsuarioLeaderboard
{
    private string $username;
    private float $score;
    private int $position;

    public function __construct(string $username, float $score, int $position)
    {
        $this->username = $username;
        $this->score = $score;
        $this->position = $position;
    }

    public function getUsername(): string { return $this->username; }
    public function getScore(): float { return $this->score; }
    public function getPosition(): int { return $this->position; }
}
