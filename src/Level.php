<?php

namespace App;

class Level 
{
    public const MULTIPLIER = 1000;

    static public function calculate(int $xp): int 
    {
        return floor($xp / self::MULTIPLIER) + 1;
    }
}
