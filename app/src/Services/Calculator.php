<?php declare (strict_types = 1);

namespace Lendable\Interview\Interpolation\Services;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\Term;

class Calculator implements FeeCalculator
{
    public const UPPER = 20000;
    public const LOWER = 1000;
    public const STEP = 5;

    private InterpolationInterface $interpolation;
    private RoundInterface $round;

    public function __construct(InterpolationInterface $interpolation, RoundInterface $round)
    {
        $this->interpolation = $interpolation;
        $this->round = $round;
    }

    public function calculate(LoanApplication $application)
    {
        $amount = (int)$application->amount();
        if ($amount < self::LOWER || $amount > self::UPPER) {
            throw new \Exception('Amount not valid');
        }

        $term = $application->term();
        try {
            $fee = $term->getFee($application->amount());
        } catch (\Exception $e) {
            $fee = $this->interpolation->interpolationFee($application->amount(), $term);
        } catch (\Exception $e) {
            throw new \Exception('Cannot calculate fee');
        }

        return $this->round->roundFee(
            (float)$fee,
            $application->amount(),
           self::STEP
        );
    }

    public function linear(float $amount, Term $term)
    {
        if ($term->isLower($amount,$term->getLowerAmount()) || $term->isUpper($amount,$term->getUppertAmount())) {
            throw new InterpolateException('Amount not valid');
        }

        $lowerAmount = $term->getNearestLowerAmount($amount);
        $upperAmount = $term->getNearestUpperAmount($amount);

        if ($lowerAmount==$upperAmount) {
            return $term->getFee($amount);
        }

        $lowerFee = $term->getFee($lowerAmount);
        $upperFee = $term->getFee($upperAmount);

        $diff = ($upperAmount-$lowerFee) / (($upperAmount-$lowerAmount) / 100) ;
        $add = $diff * (($amount-$lowerAmount) / 100 );
        return $lowerAmount+$add;
    }
}