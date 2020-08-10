<?php


abstract class Animal
{
    private string $name;
    protected int $energy = 10;

    /**
     *Animal cunstructor.
     *
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function run(): void
    {
        $this->energy--;
    }

    public function sleep(): void
    {
        $this->energy++;
    }
}