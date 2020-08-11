<?php
namespace PF;

class Dog extends Animal
{

    use ChasingBirds;

    public function run(): void
    {
        $this->energy -= 2;
    }
}