<?php

/**
 * Refactor translations: merge all flat dot-keys into their nested blocks.
 * Usage: php scripts/refactor_translations.php [--dry-run]
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Dumper;

$dryRun = in_array('--dry-run', $argv ?? [], true);

$dryRun = in_array('--dry-run', $argv ?? [], true);

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

/**
 * Flatten a nested array into dot-notation keys (for validation only).
 */
function flatArr(array $a, string $p = ''): array
{
    $r = [];
    foreach ($a as $k => $v) {
        $key = $p ? "$p.$k" : (string) $k;
        if (is_array($v)) {
            $r = array_merge($r, flatArr($v, $key));
        } else {
            $r[$key] = $v;
        }
    }
    return $r;
}

/**
 * Set a value at a given path inside a nested array.
 *
 * When a SCALAR already exists at an intermediate segment (conflict of the
 * type revit.how.step3 vs revit.how.step3.item1), we fall back to placing the
 * value as a dotted string key at the current level, e.g.:
 *   password: { reset: "...", "reset.title": "..." }
 * Symfony's translator resolves "reset.title" (literal dot key inside password:)
 * as the translation key password.reset.title — exactly what we want.
 *
 * If an ARRAY already exists at the final path, the scalar value is IGNORED
 * (the array/nested block takes structural priority).
 */
function setPath(array &$root, array $path, $value): void
{
    $cur  = &$root;
    $last = array_pop($path);

    foreach ($path as $i => $seg) {
        if (!isset($cur[$seg])) {
            $cur[$seg] = [];
        } elseif (!is_array($cur[$seg])) {
            // CONFLICT: a scalar already occupies this segment.
            // Build the remainder as a dotted key at the current level.
            $remainingSegs = array_slice($path, $i + 1);
            $flatKey       = implode('.', array_merge([$seg], $remainingSegs, [$last]));
            $cur[$flatKey] = $value;
            return;
        }
        $cur = &$cur[$seg];
    }

    // Only set if not already an array (don't turn a nested block into a scalar)
    if (!isset($cur[$last]) || !is_array($cur[$last])) {
        $cur[$last] = $value;
    }
}

// ---------------------------------------------------------------------------
// Helpers needed only inside processFile (global scope to avoid redeclaration)
// ---------------------------------------------------------------------------

/** Like flatArr but returns a flat list (duplicates preserved) for dupe detection. */
function flatKeysList(array $a, string $p = ''): array
{
    $r = [];
    foreach ($a as $k => $v) {
        $key = $p ? "$p.$k" : (string) $k;
        if (is_array($v)) {
            $r = array_merge($r, flatKeysList($v, $key));
        } else {
            $r[] = $key;
        }
    }
    return $r;
}

// ---------------------------------------------------------------------------
// Core processing
// ---------------------------------------------------------------------------

function processFile(string $inputFile, string $outputFile, bool $dryRun): void
{
    $isEN = str_ends_with($inputFile, '.en.yaml');

    $yaml = Yaml::parseFile($inputFile);

    // ---- 1. Split nested blocks vs flat root keys ----
    $nested = [];
    $flat   = [];

    foreach ($yaml as $k => $v) {
        $k = (string) $k;
        if (str_contains($k, '.')) {
            $flat[$k] = $v;
        } else {
            $nested[$k] = $v;
        }
    }

    // ---- 2. Fix broken system.currency.* inside system: block ----
    // Keys like "system.currency.COP" INSIDE system: resolve as
    // system.system.currency.COP (wrong). Remove them; the correct
    // system.currency.* values come from flat root keys below.
    if (isset($nested['system']) && is_array($nested['system'])) {
        $nested['system'] = array_filter(
            $nested['system'],
            fn($k) => !str_starts_with((string) $k, 'system.currency.'),
            ARRAY_FILTER_USE_KEY
        );
    }

    // ---- 3. Merge flat keys into nested blocks ----
    // Sort by depth asc so parent scalars are set before children try to nest.
    uksort($flat, fn($a, $b) => substr_count($a, '.') <=> substr_count($b, '.'));

    // In EN, nested block has "Hash (SHA-256)" which is better than flat "Hash"
    $keepNested = $isEN ? ['revit.label.hash'] : [];

    foreach ($flat as $dotKey => $value) {
        if (in_array($dotKey, $keepNested, true)) {
            continue;
        }

        $parts  = explode('.', $dotKey);
        $prefix = $parts[0];

        if (!isset($nested[$prefix])) {
            $nested[$prefix] = [];
        } elseif (!is_array($nested[$prefix])) {
            $nested[$prefix] = ['_value' => $nested[$prefix]];
        }

        if (count($parts) === 1) {
            $nested[$prefix] = $value;
        } else {
            setPath($nested[$prefix], array_slice($parts, 1), $value);
        }
    }

    // ---- 4. Dump ----
    $dumper  = new Dumper(2);
    $yamlOut = $dumper->dump($nested, 10, 0, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

    // ---- 5. Validate ----
    $required = flatArr(Yaml::parseFile($inputFile));

    // Remove intentionally-fixed broken keys from "required"
    foreach (array_keys($required) as $k) {
        if (str_starts_with($k, 'system.system.currency.')) {
            unset($required[$k]);
        }
    }
    if ($isEN) {
        unset($required['revit.label.hash']); // nested "Hash (SHA-256)" replaces it
    }

    $output  = flatArr(Yaml::parse($yamlOut));
    $missing = array_diff_key($required, $output);

    $dupes = array_filter(
        array_count_values(flatKeysList(Yaml::parse($yamlOut))),
        fn($c) => $c > 1
    );

    $remainFlat = array_filter(
        array_keys(Yaml::parse($yamlOut)),
        fn($k) => str_contains((string) $k, '.')
    );

    $label = basename($inputFile);
    echo "$label:\n";
    echo "  Required: " . count($required) . "  Output: " . count($output)
        . "  Missing: " . count($missing)
        . "  Dupes: " . count($dupes)
        . "  FlatLeft: " . count($remainFlat) . "\n";

    if ($missing) {
        echo "  MISSING:\n";
        foreach (array_keys($missing) as $k) {
            echo "    - $k\n";
        }
    }
    if ($dupes) {
        echo "  DUPES:\n";
        foreach (array_keys($dupes) as $k) {
            echo "    - $k\n";
        }
    }

    $clean = !$missing && !$dupes && !$remainFlat;
    echo '  ' . ($clean ? '✓ CLEAN' : '✗ ISSUES') . "\n";

    if ($dryRun) {
        echo "  (dry-run)\n\n";
        return;
    }
    if ($clean) {
        file_put_contents($outputFile, $yamlOut);
        echo "  → Written.\n\n";
    } else {
        echo "  (not written due to issues)\n\n";
    }
}

// ---------------------------------------------------------------------------
// Run
// ---------------------------------------------------------------------------

processFile(
    __DIR__ . '/../translations/messages.es.yaml',
    __DIR__ . '/../translations/messages.es.yaml',
    $dryRun
);

processFile(
    __DIR__ . '/../translations/messages.en.yaml',
    __DIR__ . '/../translations/messages.en.yaml',
    $dryRun
);
