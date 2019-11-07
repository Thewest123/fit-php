<?php

namespace HW\Lib;


class MathUtils
{
    /**
     * Sum a list of numbers.
     *
     * @param $list
     * @return int
     */
    public static function sum($list)
    {
        $sum = 0;
        $i = 0;

        while (++$i < sizeof($list)) {
            $sum += $list[$i];
        }

        return $sum;
    }

    /**
     * Solve linear equation ax + b = 0.
     *
     * @param $a
     * @param $b
     * @return float|int
     */
    public static function solveLinear($a, $b)
    {
        if ($a === 0) {
            throw new \InvalidArgumentException();
        }

        return -$b / $a;
    }

    /**
     * Solve quadratic equation ax^2 + bx + c = 0.
     *
     * @param $a
     * @param $b
     * @param $c
     * @return array Solution x1 and x2.
     */
    public static function solveQuadratic($a, $b, $c)
    {
        $d = sqrt(pow($b, 2) - 4 * $a * $c);
        $x1 = (-$b + $d) / (2 * $a);
        $x2 = ($b - $d) / (2 * $a);
        return [$x1, $x2];
    }
}
