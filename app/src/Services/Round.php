<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Services;

class Round implements RoundInterface
{
    public function roundFee(float $fee, float $amount, float $div)
    {
        $remain = ($fee + $amount) % $div;
        if ($remain > 0) {
            return $fee + ($div - $remainder);
        }

        return $fee;
    }
}
