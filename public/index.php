<?php

class Foo {
    public string $bar;
}

$foo = new Foo;
$foo->bar = 'Hello world!';

echo $foo->bar;

class Person
{
    private string $name;

    /**
     * Person constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}

$arr = [
    new Person('Johnny'),
    new Person('Billy'),
    new Person('Anna'),];

var_dump(usort($arr, function(Person $person1, Person $person2) {
    return $person1->getName() > $person2->getName();
}));

var_dump(usort($arr, fn(Person $person1, Person $person2) => $person1->getName() > $person2->getName()));


//Unit testing
class Fooo
{
    private UserRepo $userRepo;

    /**
     * Fooo constructor.
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function bar()
    {
        $this->userRepo->selectUser();
    }
}

class UserRepo
{
    public function selectUser()
    {
        // select * from users where id = 1
    }
}