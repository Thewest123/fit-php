<?php declare(strict_types=1);

namespace HW\Lib;

interface Storage
{
    function save($key, $value);

    function get($key);
}
