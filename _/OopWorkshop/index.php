<?php

use PF\Cat;
use PF\Dog;

require_once 'vendor/autoload.php';

$muris= new Dog('Muris');
$reksis = new Cat('Reksis');
$muris->run();
$muris->sleep();
$muris->sleep();
$muris->sleep();
$muris->sleep();
$reksis->run();
$reksis->run();
var_dump($muris,$reksis,$muris::$animalCount);

Dog::foo();

class A {
    public static string $foo = 'a';

    public static function foo(): string
    {
        return static::$foo;
    }
}

class B extends A {
    public static string $foo = 'b';
}

class C extends A {
    public static string $foo = 'c';
}

var_dump(B::foo());
var_dump(C::foo());