<?php

namespace App;

use Exception;

class Arena
{
    private array $monsters;
    private Hero $hero;

    private int $size = 10;

    public function __construct(Hero $hero, array $monsters)
    {
        $this->hero = $hero;
        $this->monsters = $monsters;
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
    public function getMonsters(): array
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

    public function move(Fighter $fighter, string $direction)
    {
        $newX = $fighter->getX();
        $newY = $fighter->getY();

        if ($direction === "N") {
            $newY--;
        } elseif ($direction === "S") {
            $newY++;
        } elseif ($direction === "W") {
            $newX--;
        } elseif ($direction === "E") {
            $newX++;
        }

        if ($newX < 0 || $newX >= $this->size || $newY < 0 || $newY >= $this->size) {
            throw new Exception("Déplacement impossible : en dehors de la carte");
        }

        foreach ($this->monsters as $monster) {
            if ($monster->getX() === $newX && $monster->getY() === $newY) {
                throw new Exception("Déplacement impossible : case occupée");
            }
        }

        $fighter->setX($newX);
        $fighter->setY($newY);
    }


    public function battle(int $id)
    {
        $hero = $this->getHero();
        $monster = $this->monsters[$id];

        if ($this->getDistance($hero, $monster) <= $hero->getRange()) {
            $hero->fight($monster);

            if (!$monster->isAlive()) {
                unset($this->monsters[$id]);
                $this->monsters = array_values($this->monsters);

                $hero->addExperience($monster->getExperience());
            }

            if ($monster->isAlive()) {
                if ($this->getDistance($monster, $hero) <= $monster->getRange()) {
                    $monster->fight($hero);
                }
            }
        }
    }
}
