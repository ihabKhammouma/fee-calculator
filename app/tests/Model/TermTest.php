<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Tests\Model;

use Lendable\Interview\Interpolation\Model\Term;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class TermTest extends TestCase
{
    public function testFeeFromAmount(): void
    {
        $term = new Term();
        $term->addBreakpoint(1500, 150);
        $term->addBreakpoint(2700, 250);

        Assert::assertEquals(150, $term->getFee(1500));
    }

    public function testExceptionAmountNotFound(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Amount not found');

        $term->getFee(2300);
    }

    public function testExceptionAmountNotvalid(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Amount is not valid');

        $term->getFee(99999);
        $term->getFee(3100);
    }

    public function testLowerAmount(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        Assert::assertEquals(2200, $term->getLowerAmount());
    }

    public function testUpperAmount(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        Assert::assertEquals(3000, $term->getUppertAmount());
    }

    public function testNearestLowerAmount(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);
        
        Assert::assertEquals(2200, $term->getNearestLowerAmount(2200));
        Assert::assertEquals(2200, $term->getNearestLowerAmount(2999));
    }

    public function testNearestUpperAmount(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        Assert::assertEquals(3000, $term->getNearestUpperAmount(3000));
        Assert::assertEquals(3000, $term->getNearestUpperAmount(2999));
    }
}
