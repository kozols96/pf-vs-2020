<?php

require_once 'Animal.php';
require_once 'Dog.php';
require_once 'Cat.php';

$muris= new Dog('Muris');
$reksis = new Cat('Reksis');
$muris->run();
$muris->sleep();
$muris->sleep();
$muris->sleep();
$muris->sleep();
$reksis->run();
$reksis->run();
var_dump($muris,$reksis);