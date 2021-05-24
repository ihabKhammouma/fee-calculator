<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Services;

use Lendable\Interview\Interpolation\Model\Term;

class Interpolation implements InterpolationInterface
{
    public function interpolationFee(float $amount, Term $term)
    {
        if ($term->isLower($amount, $term->getLowerAmount()) || $term->isUpper($amount, $term->getUppertAmount())) {
            throw new \Exception('Amount not valid');
        }

        $lowerAmount = $term->getNearestLowerAmount($amount);
        $upperAmount = $term->getNearestUpperAmount($amount);

        if ($lowerAmount == $upperAmount) {
            return $term->getFee($amount);
        }

        $lowerFee = (string) $term->getFee($lowerAmount);
        $upperFee = (string) $term->getFee($upperAmount);

        $diff = ($upperFee - $lowerFee) / (($upperAmount - $lowerAmount) / 100);
        $add = $diff * (($amount - $lowerAmount) / 100);
        return $add + $lowerFee;
    }
}
