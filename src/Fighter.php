<?php

namespace App;

class Fighter
{
    public const MAX_LIFE = 100;

    private string $name;
    private int $strength;
    private int $dexterity;
    private string $image = 'fighter.svg';
    private int $life = self::MAX_LIFE;
    private int $x;
    private int $y;
    protected float $range = 1;

    public function __construct(
        string $name,
        int $strength = 10,
        int $dexterity = 5,
        string $image = 'fighter.svg'
    ) {
        $this->name = $name;
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->image = $image;
    }

    
    public function getDamage(): int
    {
        $damage = $this->getStrength();

        return $damage;
    }

    public function getDefense(): int
    {
        $defense = $this->getDexterity();

        return $defense;
    }



    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return 'assets/images/' . $this->image;
    }


    public function fight(Fighter $adversary): void
    {
        $damage = rand(1, $this->getDamage()) - $adversary->getDefense();
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
    }

    /**
     * Get the value of life
     */
    public function getLife(): int
    {
        return $this->life;
    }

    /**
     * Set the value of life
     *
     */
    public function setLife(int $life)
    {
        if ($life < 0) {
            $life = 0;
        }
        $this->life = $life;
    }

    public function isAlive(): bool
    {
        return $this->getLife() > 0;
    }

    /**
     * Get the value of strength
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * Set the value of strength
     *
     */
    public function setStrength($strength): void
    {
        $this->strength = $strength;
    }

    /**
     * Get the value of dexterity
     */
    public function getDexterity(): int
    {
        return $this->dexterity;
    }

    /**
     * Set the value of dexterity
     *
     */
    public function setDexterity($dexterity): void
    {
        $this->dexterity = $dexterity;
    }

    /**
     * Get the value of x
     */ 
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Set the value of x
     */ 
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * Get the value of y
     */ 
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Set the value of y
    */ 
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * Get the value of range
     */ 
    public function getRange(): float
    {
        return $this->range;
    }
}
