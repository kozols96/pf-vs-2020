<?php
namespace PF;

class Parrot extends Animal implements Flyable
{
    public function fly(): void
    {
        $this->energy -= 3;
    }
}