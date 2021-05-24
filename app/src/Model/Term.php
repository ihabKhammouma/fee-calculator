<?php declare (strict_types = 1);

namespace Lendable\Interview\Interpolation\Model;

class Term
{
    private array $breakpoints;
    private float $lowerAmount;
    private float $uppertAmount;
    public function __construct()
    {
        $this->lowerAmount = 0;
        $this->uppertAmount = 0;
    }

    public function addBreakpoint(float $loanAmount, float $fee): void
    {
        $this->breakpoints[(int)$loanAmount] = (int)$fee;
        if ($this->isLower($loanAmount,$this->lowerAmount) || $this->isZero($this->lowerAmount)) {
            $this->lowerAmount = $loanAmount;
        }
        if ($this->isUpper($loanAmount,$this->uppertAmount) || $this->isZero($this->uppertAmount)) {
            $this->uppertAmount = $loanAmount;
        }
    }

    public function getLowerAmount(): float
    {
        return $this->lowerAmount;
    }

    public function getUppertAmount(): float
    {
        return $this->uppertAmount;
    }

    public function getFee(float $amount)
    {
        $breakpoint = $amount;
        if (array_key_exists((string)$breakpoint, $this->breakpoints)) {
            return $this->breakpoints[$breakpoint];
        }
        if ($this->isLower($amount,$this->lowerAmount) || $this->isUpper($amount,$this->uppertAmount)) {
            throw new \Exception('Amount is not valid');
        }

        throw new \Exception('Amount not found');
    }


    /**
     * Checks whether the first value is Lower than the other.
     *
     *
     * @return bool
     */
    public function isLower(float $first, float $second)
    {
        return bccomp((string)$first, (string)$second) < 0;
    }
    /**
     * Checks whether the first value is Upper than the other.
     *
     *
     * @return bool
     */
    public function isUpper(float $first, float $second)
    {
        return bccomp((string)$first, (string)$second) > 0;
    }
    /**
     * Checks whether is zero.
     *
     *
     * @return bool
     */
    public function isZero(float $amount)
    {
        return bccomp((string)$amount,'0') === 0;
    }

    public function getNearestLowerAmount(float $money)
    {
        $amount = (int)$money;

        $lowerAmount = 0;
        foreach ($this->breakpoints as $breakpoint => $fee) {
            if ($amount === $breakpoint) {
                return $amount;
            }

            $i = $breakpoint - $amount;
            if ($i < 0 && ($breakpoint > $lowerAmount || 0 === $lowerAmount)) {
                $lowerAmount = $breakpoint;
            }
        }

        return $lowerAmount;
    }

    public function getNearestUpperAmount(float $money)
    {
        $amount = (int)$money;

        $upperAmount = 0;
        foreach ($this->breakpoints as $breakpoint => $fee) {
            if ($amount === $breakpoint) {
                return $amount;
            }

            $i = $breakpoint - $amount;
            if ($i > 0 && ($breakpoint < $upperAmount || 0 === $upperAmount)) {
                $upperAmount = $breakpoint;
            }
        }

        return $upperAmount;
    }
}