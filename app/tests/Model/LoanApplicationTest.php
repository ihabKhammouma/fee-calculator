<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Tests\Model;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\Term;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class LoanApplicationTest extends TestCase
{
    public function testValidLoan(): void
    {
        $term = new Term();
        $application = new LoanApplication($term, 2750);

        Assert::assertEquals($term, $application->term());
        Assert::assertEquals(2750, $application->amount());
    }

    public function testAmountNotvalid(): void
    {
        $this->expectException(\Exception::class);
        $this->expectErrorMessage('Amount not valid');

        $term = new Term();
        new LoanApplication($term, -100);
    }
}
