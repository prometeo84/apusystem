<?php
// Minimal stubs for core functions used by static analysis
// Provide RAND_MAX constant for static analysis when missing
if (!defined('RAND_MAX')) {
    define('RAND_MAX', 2147483647);
}
if (!function_exists('random_bytes')) {
    function random_bytes(int $length): string
    {
        return str_repeat("\0", max(0, $length));
    }
}

if (!function_exists('random_int')) {
    function random_int(int $min, int $max): int
    {
        return $min;
    }
}

if (!function_exists('mt_rand')) {
    function mt_rand(int $min = 0, int $max = RAND_MAX): int
    {
        return $min;
    }
}

if (!function_exists('rand')) {
    function rand(int $min = 0, int $max = RAND_MAX): int
    {
        return $min;
    }
}
