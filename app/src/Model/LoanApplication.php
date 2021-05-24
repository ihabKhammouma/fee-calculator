<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Model;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
class LoanApplication
{
    /**
     * @var Term
     */
    private $term;

    /**
     * @var float
     */
    private $amount;

    public function __construct(Term $term, float $amount)
    {
        if ($amount < 0) {
            throw new \Exception('Amount not valid');
        }

        $this->term = $term;
        $this->amount = $amount;
    }

    /**
     * Term (loan duration) for this loan application
     * in number of months.
     */
    public function term(): Term
    {
        return $this->term;
    }

    /**
     * Amount requested for this loan application.
     */
    public function amount(): float
    {
        return $this->amount;
    }
}
