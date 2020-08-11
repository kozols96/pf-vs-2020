<?php
namespace PF;

class Cat extends Animal
{

    use ChasingBirds;

    public function run(): void
    {
        $this->energy -=2;
    }
}