<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Tests\Services;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\Term;
use Lendable\Interview\Interpolation\Services\Calculator;
use Lendable\Interview\Interpolation\Services\InterpolationInterface;
use Lendable\Interview\Interpolation\Services\RoundInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CalculatorTest extends TestCase
{
    use ProphecyTrait;

    public function testWithoutInterpolating(): void
    {
        $interpolate = $this->prophesize(InterpolationInterface::class);
        $round = $this->prophesize(RoundInterface::class);
        $calculator = new Calculator($interpolate->reveal(), $round->reveal());

        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $application = new LoanApplication($term, 2200);
        $round->roundFee(100, 2200, 5)->shouldBeCalled()->willReturn(100);

        Assert::assertEquals(100, $calculator->calculate($application));

        $application = new LoanApplication($term, (3000));
        $round->roundFee(170, 3000, 5)->shouldBeCalled()->willReturn(170);

        Assert::assertEquals(170, $calculator->calculate($application));
    }

    public function testInterpolating(): void
    {
        $interpolate = $this->prophesize(InterpolationInterface::class);
        $round = $this->prophesize(RoundInterface::class);
        $calculator = new Calculator($interpolate->reveal(), $round->reveal());

        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $application = new LoanApplication($term, 2600);
        $interpolate->interpolationFee(2600, $term)->shouldBeCalled()->willReturn(135);
        $round->roundFee(135, 2600, 5)->shouldBeCalled()->willReturn(135);

        Assert::assertEquals(135, $calculator->calculate($application));
    }

    public function testExceptionLowerLimit(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $calculator = new Calculator($this->prophesize(InterpolationInterface::class)->reveal(), $this->prophesize(RoundInterface::class)->reveal());
        $application = new LoanApplication($term, (10));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Amount not valid');

        $calculator->calculate($application);
    }

    public function testExceptionUpperLimit(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);
        $calculator = new Calculator($this->prophesize(InterpolationInterface::class)->reveal(), $this->prophesize(RoundInterface::class)->reveal());
        $application = new LoanApplication($term, 30001);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Amount not valid');

        $calculator->calculate($application);
    }
}
