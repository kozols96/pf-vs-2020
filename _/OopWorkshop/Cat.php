<?php


class Cat extends Animal
{
    public function run(): void
    {
        $this->energy -=2;
    }
}