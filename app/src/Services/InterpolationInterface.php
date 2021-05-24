<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Services;

use Lendable\Interview\Interpolation\Model\Term;

interface InterpolationInterface
{
    public function interpolationFee(float $amount, Term $term);
}
