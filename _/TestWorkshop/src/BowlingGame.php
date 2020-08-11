<?php


class BowlingGame
{
    const All = 10;
    private array $throws = [];

    public function throw(int $points): void
    {
        $this->throws[] += $points;
    }

    public function getScore(): int
    {
        $score = 0;
        $throw = 0;

        for ($i = 0; $i < self::All; $i++) {

            if ($this->isAStrike($throw)) {
                $score += $this->getStrikeBonus($throw);
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
     * @param int $throw
     * @return bool
     */
    public function isAStrike(int $throw): bool
    {
        return $this->throws[$throw] === self::All;
    }

    /**
     * @param int $throw
     * @return int|mixed
     */
    public function getStrikeBonus(int $throw): int
    {
        return self::All + $this->throws[$throw + 1] + $this->throws[$throw + 2];
    }

    /**
     * @param int $i
     * @return bool
     */
    public function isASpare(int $i): bool
    {
        return $this->getFrameScore($i) === self::All;
    }

    /**
     * @param int $throw
     * @return mixed
     */
    public function getSpareBonus(int $throw): int
    {
        return $this->throws[$throw + 2];
    }

    /**
     * @param int $i
     * @return mixed
     */
    public function getFrameScore(int $i): int
    {
        return $this->throws[$i] + $this->throws[$i + 1];
    }
}