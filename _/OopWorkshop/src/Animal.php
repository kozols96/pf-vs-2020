<?php
namespace PF;

abstract class Animal
{
    private string $name;
    protected int $energy = 10;

    public static int $animalCount = 0;

    /**
     * Animal constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        self::$animalCount++;
    }

    public function run(): void
    {
        $this->energy--;
    }

    public function sleep(): void
    {
        $this->energy++;
    }

    public static function foo()
    {

    }
}