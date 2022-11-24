<?php declare(strict_types=1);

namespace HW\Lib;

class MathUtils
{
    /**
     * Sum a list of numbers.
     */
    public static function sum(array $list): float|int
    {
        $sum = 0;
        $i = 0;

        while ($i < count($list)) {

            if (!is_numeric($list[$i]))
                throw new \InvalidArgumentException("List can contain only numeric values");

            $sum += $list[$i++];
        }

        return $sum;
    }

    /**
     * Solve linear equation ax + b = 0.
     */
    public static function solveLinear(int|float $a, int|float $b): float|int
    {
        if ($a === 0) {
            throw new \InvalidArgumentException();
        }

        return -$b / $a;
    }

    /**
     * Solve quadratic equation ax^2 + bx + c = 0.
     *
     * @return array Solution x1 and x2.
     */
    public static function solveQuadratic(int|float $a, int|float $b, int|float $c): array
    {
        if (2 * $a === 0) {
            throw new \InvalidArgumentException();
        }

        $d = sqrt(pow($b, 2) - 4 * $a * $c);
        $x1 = (-$b + $d) / (2 * $a);
        $x2 = (-$b - $d) / (2 * $a);
        return [$x1, $x2];
    }
}
