<?php


class BowlingGame
{
    private array $throws = [];

    public function throw(int $points): void
    {
        $this->throws[] += $points;
    }

    public function getScore(): int
    {
        $score = 0;
        $throw = 0;

        for ($i = 0; $i < 10; $i++) {

            if ($this->isAStrike($throw)) {
                $score += $this->getStrikeScore($throw);
                $throw += 1;
                continue;
            }

            if ($this->isASpare($throw)) {
                $score += $this->getSpareBonus($throw);
            }

            $score += $this->getFrameScore($throw);
            $throw += 2;
        }

        return $score;
    }

    /**
     * @param int $i
     * @return mixed
     */
    public function getFrameScore(int $i)
    {
        return $this->throws[$i] + $this->throws[$i + 1];
    }

    /**
     * @param int $i
     * @return bool
     */
    public function isASpare(int $i): bool
    {
        return $this->getFrameScore($i) === 10;
    }

    /**
     * @param int $i
     * @return mixed
     */
    public function getSpareBonus(int $throw): int
    {
        return $this->throws[$throw + 2];
    }

    /**
     * @param int $throw
     * @return bool
     */
    public function isAStrike(int $throw): bool
    {
        return $this->throws[$throw] === 10;
    }

    /**
     * @param int $throw
     * @return int|mixed
     */
    public function getStrikeScore(int $throw)
    {
        return 10 + $this->throws[$throw + 1] + $this->throws[$throw + 2];
    }
}