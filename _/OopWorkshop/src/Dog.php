<?php
require_once 'ChasingBirds.php';

class Dog extends Animal
{

    use ChasingBirds;

    public function run(): void
    {
        $this->energy -= 2;
    }
}