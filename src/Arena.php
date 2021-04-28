<?php

namespace App;

use Exception;
use SplObjectStorage;

class Arena 
{
    private SplObjectStorage $monsters;
    private Hero $hero;

    private int $size = 10;

    public function __construct(Hero $hero, array $monsters)
    {
        $this->hero = $hero;
        $this->monsters = new SplObjectStorage();
        foreach($monsters as $monster) {
            $this->monsters->attach($monster);
        }
    }

    private function getMonster(int $id): Monster
    {
       foreach($this->getMonsters() as $key => $monster) {
            if($key === $id) {
                return $monster;
            }
        }

        throw new Exception('No monster found');
    }

    public function fight(int $id)
    {
        $monster = $this->getMonster($id);
        if($this->touchable($this->getHero(), $monster)) { 
            $this->getHero()->fight($monster);
        } else {
            throw new Exception('Monster out of range');
        }

        if(!$monster->isAlive()) {
            $this->getHero()->setXp($this->getHero()->getXp() + $monster->getXp());
            $this->getMonsters()->detach($monster);
        }   

        if($this->touchable($monster, $this->getHero())) { 
            $monster->fight($this->getHero());
        } else {
            throw new Exception('Hero out of range');
        }
    }

    public function move(Fighter $fighter, string $direction): void 
    {
        $x = $fighter->getX();
        $y = $fighter->getY();

        if ($direction === 'W') {
            $x--;
        }  
        if ($direction === 'E') {
            $x++;
        }
        if ($direction === 'N') {
            $y--;
        }  
        if ($direction === 'S') {
            $y++;
        }

        $this->checkMove($x, $y);
        $fighter->setX($x);
        $fighter->setY($y);
    }

    private function checkMove($x, $y) 
    {
        if($x<0 || $x>=$this->getSize() || $y<0 || $y>=$this->getSize()) {
            throw new Exception('Out of map');
        }
        
        foreach($this->getMonsters() as $monster) {
            if($monster->getX() === $x && $monster->getY() === $y) {
                throw new Exception('Position is not free');
            }
        }
    }

    public function getDistance(Fighter $startFighter, Fighter $endFighter): float
    {
        $Xdistance = $endFighter->getX() - $startFighter->getX();
        $Ydistance = $endFighter->getY() - $startFighter->getY();
        return sqrt($Xdistance ** 2 + $Ydistance ** 2);
    }

    public function touchable(Fighter $attacker, Fighter $defenser): bool 
    {
        return $this->getDistance($attacker, $defenser) <= $attacker->getRange();
    }

    /**
     * Get the value of monsters
     */ 
    public function getMonsters(): SplObjectStorage
    {
        return $this->monsters;
    }

    /**
     * Set the value of monsters
     *
     */ 
    public function setMonsters($monsters): void
    {
        $this->monsters = $monsters;
    }

    /**
     * Get the value of hero
     */ 
    public function getHero(): Hero
    {
        return $this->hero;
    }

    /**
     * Set the value of hero
     */ 
    public function setHero($hero): void
    {
        $this->hero = $hero;
    }

    /**
     * Get the value of size
     */ 
    public function getSize(): int
    {
        return $this->size;
    }
}