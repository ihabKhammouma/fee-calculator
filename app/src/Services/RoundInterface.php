<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Services;

interface RoundInterface
{
    public function roundFee(float $fee, float $amount, float $divisor);
}
