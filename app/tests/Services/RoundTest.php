<?php declare(strict_types = 1);

namespace Lendable\Interview\Interpolation\Tests\Service;

use Lendable\Interview\Interpolation\Services\Round;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class RoundTest extends TestCase
{
    public function testRound(): void
    {
        $divisor = 5;
        $round = new Round();
        
        Assert::assertEquals(506, $round->roundFee(501, 20000, $divisor));
        Assert::assertEquals(607, $round->roundFee(602, 2750, $divisor));
        Assert::assertEquals(1100, $round->roundFee(1100, 27500, $divisor));
    }
}
