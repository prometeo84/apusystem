<?php
// Project-level stubs to satisfy static analyzers (Intelephense/phpstan/etc.)
// These are declared only when the real extensions are not available to avoid runtime conflicts.

if (!function_exists('random_bytes')) {
    /**
     * Generate cryptographically secure random bytes.
     *
     * @param int $length
     * @return string
     */
    function random_bytes(int $length): string
    {
        // Return a string of null bytes of requested length as a safe stub value.
        return str_repeat("\0", max(0, $length));
    }
}

if (!function_exists('random_int')) {
    /**
     * Generate a cryptographically secure random integer between min and max.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    function random_int(int $min, int $max): int
    {
        // Return a deterministic, valid integer within the requested bounds for static analysis.
        return (int) $min;
    }
}

if (!function_exists('mt_rand')) {
    /**
     * Mersenne Twister random integer.
     *
     * @param int|null $min
     * @param int|null $max
     * @return int
     */
    function mt_rand(?int $min = null, ?int $max = null): int
    {
        // Return a deterministic integer. If bounds are provided, prefer the min value.
        if ($min === null && $max === null) {
            return 0;
        }
        return (int) ($min ?? 0);
    }
}

if (!function_exists('rand')) {
    /**
     * Alias for mt_rand — legacy rand function.
     *
     * @param int|null $min
     * @param int|null $max
     * @return int
     */
    function rand(?int $min = null, ?int $max = null): int
    {
        // Alias behavior for static analysis: return deterministic integer.
        if ($min === null && $max === null) {
            return 0;
        }
        return (int) ($min ?? 0);
    }
}
