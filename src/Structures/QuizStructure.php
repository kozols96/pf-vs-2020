<?php


namespace Project\Structures;


use Project\Interfaces\RpcResponseInterface;


class QuizStructure implements RpcResponseInterface
{

    public ?int $id = null;
    public ?string $name = null;
    public ?int $questionCount = null;

    public function toArray(): array
    {
        return (array)$this;
    }
}