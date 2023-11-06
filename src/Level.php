<?php

namespace App;

class Level
{
    public static function calculate(int $experience): int
    {
        $level = ceil($experience / 1000);
        return $level;
    }
}
