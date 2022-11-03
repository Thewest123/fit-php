<?php declare(strict_types=1);

namespace HW\Tests;

use HW\Lib\MathUtils;
use PHPUnit\Framework\TestCase;

/** @covers \HW\Lib\MathUtils */
class MathUtilsTest extends TestCase
{
    private MathUtils $math;

    protected function setUp(): void
    {
        $this->math = new MathUtils();
    }

    public function testSumInt()
    {
        $this->assertEquals(15, $this->math::sum([1,2,3,4,5]));
        $this->assertEquals(-15, $this->math::sum([-1,-2,-3,-4,-5]));
        $this->assertEquals(5, $this->math::sum([1,2,3,4,-5]));
    }

    public function testSumFloat()
    {
        $this->assertEquals(15.5, $this->math::sum([1,2,3,4,5.5]));
    }

    public function testSumNonNumeric()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("List can contain only numeric values");
        $this->math::sum([1, 2, "3", ["hello", "world"]]);
    }

    public function testSolveLinearInt()
    {
        $this->assertEquals(1, $this->math::solveLinear(5, -5));
        $this->assertEquals(1, $this->math::solveLinear(-5, 5));
        $this->assertEquals(-1, $this->math::solveLinear(-5, -5));
    }

    public function testSolveLinearFloat()
    {
        $this->assertEqualsWithDelta(-0.588235, $this->math::solveLinear(-3.4, -2), 1e-06);
    }

    public function testSolveLinearDivideByZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->math::solveLinear(0, 42);
    }

    public function testSolveQuadratic()
    {
        $result = $this->math::solveQuadratic(5, 10, -40);
        $this->assertContainsEquals(2, $result);
        $this->assertContainsEquals(-4, $result);
    }

    public function testSolveQuadraticDivideByZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->math::solveQuadratic(0, 10, -40);
    }
}
