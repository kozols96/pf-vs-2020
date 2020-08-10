<?php

class Foo {
    public string $bar;
}

$foo = new Foo;
$foo->bar = 'Hello world!';

echo $foo->bar;