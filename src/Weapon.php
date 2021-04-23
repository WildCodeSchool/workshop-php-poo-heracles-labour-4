<?php

namespace App;

class Weapon
{
    private int $damage = 10;

    private string $image = 'sword.svg';
    private float $range = 0.5;
    
    public function __construct(int $damage, float $range=0.5, string $image='sword.svg')
    {
        $this->damage = $damage;
        $this->range = $range;
        $this->image = $image;
    }
    
    public function getDamage(): int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): void
    {
        $this->damage = $damage;
    }

    public function getImage(): string
    {
        return 'assets/images/' . $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * Get the value of range
     */ 
    public function getRange(): float
    {
        return $this->range;
    }
}