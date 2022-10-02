<?php declare(strict_types=1);

const DEAD = '.';
const ALIVE = 'X';



function readInput($string): array
{
    $gameArr = [];

    $lines = explode("\n", $string);
    $linesCount = count($lines);

    for ($i = 0; $i < $linesCount; $i++)
    {
        $gameArr[$i] = str_split($lines[$i]);
    }

    return $gameArr;

}

function writeOutput($matrix): string
{
    $output = "";

    foreach ($matrix as $line)
    {
        $charCount = count($line);
        for ($i = 0; $i < $charCount; $i++)
        {
            $output .= $line[$i];
        }

        $output .= PHP_EOL;
    }

    return $output;

}


function gameStep($matrix)
{
    $newMatrix = $matrix;
    $lineCount = count($matrix);
    for ($i = 0; $i < $lineCount; $i++)
    {
        $charCount = count($matrix[$i]);

        for ($j = 0; $j < $charCount; $j++)
        {
            $neighborCount = countNeighbors($matrix, $i, $j);
            $currChar = $matrix[$i][$j];

            if ($currChar === ALIVE)
            {
                if ($neighborCount < 2)
                    $newMatrix[$i][$j] = DEAD;

                if ($neighborCount > 3)
                    $newMatrix[$i][$j] = DEAD;
            }
            elseif ($currChar === DEAD and $neighborCount === 3)
                $newMatrix[$i][$j] = ALIVE;
        }
    }

    return $newMatrix;
}


function countNeighbors($matrix, $i, $j): int
{
    $neighborCount = 0;

    // Top Left
    if ($i-1 >= 0 and $j-1 >= 0)
        if ($matrix[$i-1][$j-1] === ALIVE)
            $neighborCount++;

    // Top Middle
    if ($i-1 >= 0)
        if ($matrix[$i-1][$j] === ALIVE)
            $neighborCount++;

    // Top Right
    if ($i-1 >= 0 and $j+1 < count($matrix[$i-1]))
        if ($matrix[$i-1][$j+1] === ALIVE)
            $neighborCount++;

    // Middle Left
    if ($j-1 >= 0)
        if ($matrix[$i][$j-1] === ALIVE)
            $neighborCount++;

    // Middle Right
    if ($j+1 < count($matrix[$i]))
        if ($matrix[$i][$j+1] === ALIVE)
            $neighborCount++;

    $linesCount = count($matrix);

    // Bottom Left
    if ($i+1 < $linesCount and $j-1 >= 0)
        if ($matrix[$i+1][$j-1] === ALIVE)
            $neighborCount++;

    // Bottom Middle
    if ($i+1 < $linesCount)
        if ($matrix[$i+1][$j] === ALIVE)
            $neighborCount++;

    // Bottom Right
    if ($i+1 < $linesCount and $j+1 < count($matrix[$i+1]))
        if ($matrix[$i+1][$j+1] === ALIVE)
            $neighborCount++;

    return $neighborCount;
}