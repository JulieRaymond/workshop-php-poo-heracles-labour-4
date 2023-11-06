<?php

namespace App;

class Monster extends Fighter
{
    protected int $experience = 500;

    public function getExperience(): int
    {
        return $this->experience;
    }
}
