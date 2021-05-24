<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Tests\Services;

use Lendable\Interview\Interpolation\Model\Term;
use Lendable\Interview\Interpolation\Services\Interpolation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class InterpolationTest extends TestCase
{
    public function testExceptionAmountnotValid(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);

        $interpolation = new Interpolation();

        $this->expectExceptionMessage('Amount not valid');
        $this->expectException(\Exception::class);
        $interpolation->interpolationFee(3001, $term);
    }

    public function testIterpolate(): void
    {
        $term = new Term();
        $term->addBreakpoint(2200, 100);
        $term->addBreakpoint(3000, 170);
        $interpolation = new Interpolation();

        Assert::assertEquals(170, $interpolation->interpolationFee(3000, $term));
        Assert::assertEquals(135, $interpolation->interpolationFee(2600, $term));
        Assert::assertEquals(152.5, $interpolation->interpolationFee(2800, $term));
    }
}
