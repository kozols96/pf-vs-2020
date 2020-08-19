<?php


namespace Project\Structures;


use Project\Interfaces\RpcResponseInterface;


class QuestionStructure implements RpcResponseInterface
{

    public ?int $id = null;
    public ?int $quizId = null;
    public ?string $title = null;

    /**
     * @var AnswerStructure[] $answers
     */
    public array $answers = [];

    public function toArray(): array
    {
        return (array)$this;
    }
}