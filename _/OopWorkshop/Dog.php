<?php


class Dog extends Animal
{
    public function run(): void
    {
        $this->energy -= 2;
    }
}