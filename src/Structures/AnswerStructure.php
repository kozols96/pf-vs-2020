<?php


namespace Project\Structures;


use Project\Interfaces\RpcResponseInterface;


class AnswerStructure implements RpcResponseInterface
{

    public ?int $id = null;
    public ?int $questionId = null;
    public ?string $title = null;

    public function toArray(): array
    {
        return (array)$this;
    }
}