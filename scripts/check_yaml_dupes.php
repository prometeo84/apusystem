<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

function flattenArr(array $a, string $p = ''): array
{
    $r = [];
    foreach ($a as $k => $v) {
        $key = $p ? "$p.$k" : (string) $k;
        if (is_array($v)) {
            $r = array_merge($r, flattenArr($v, $key));
        } else {
            $r[$key] = $v;
        }
    }
    return $r;
}

function checkFile(string $file): void
{
    $yaml   = Yaml::parseFile($file);
    $label  = basename($file);
    echo "\n=== $label ===\n";

    // Nested-block values
    $nestedVals = [];
    foreach ($yaml as $k => $v) {
        if (!str_contains((string)$k, '.') && is_array($v)) {
            foreach (flattenArr($v, $k) as $fk => $fv) {
                $nestedVals[$fk] = $fv;
            }
        }
    }

    // Flat keys (root level, with dots)
    $flatVals = [];
    foreach ($yaml as $k => $v) {
        if (str_contains((string)$k, '.') && !is_array($v)) {
            $flatVals[$k] = $v;
        }
    }

    echo 'Root-level flat keys: ' . count($flatVals) . "\n";

    $diff = 0;
    foreach ($flatVals as $k => $v) {
        if (isset($nestedVals[$k]) && $nestedVals[$k] !== $v) {
            echo "  VALUE CONFLICT: $k\n";
            echo "    NESTED: {$nestedVals[$k]}\n";
            echo "    FLAT:   $v\n";
            $diff++;
        }
    }
    if (!$diff) {
        echo "  No value conflicts between nested blocks and flat keys.\n";
    }

    // How many flat keys have a duplicate in a nested block
    $dupCount = count(array_filter(array_keys($flatVals), fn($k) => isset($nestedVals[$k])));
    echo "  Flat keys that duplicate a nested block key: $dupCount\n";

    // Groups of flat keys
    $groups = [];
    foreach ($flatVals as $k => $v) {
        $p = explode('.', $k)[0];
        $groups[$p] = ($groups[$p] ?? 0) + 1;
    }
    ksort($groups);
    echo "  Flat key groups:\n";
    foreach ($groups as $p => $c) {
        echo "    $p: $c\n";
    }
}

checkFile(__DIR__ . '/../translations/messages.es.yaml');
checkFile(__DIR__ . '/../translations/messages.en.yaml');
