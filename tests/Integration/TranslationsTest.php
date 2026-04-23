<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Yaml\Yaml;

class TranslationsTest extends TestCase
{
    /** Flattens a nested YAML array into dot-notation keys. */
    private static function flattenKeys(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $fullKey = $prefix !== '' ? "$prefix.$key" : (string) $key;
            if (is_array($value)) {
                $result = array_merge($result, self::flattenKeys($value, $fullKey));
            } else {
                $result[$fullKey] = $value;
            }
        }
        return $result;
    }

    /** @return array[] */
    public static function providerKeys(): array
    {
        return [
            // Original keys
            ['auth.reauth'],
            ['auth.reauth_prompt'],
            ['auth.confirm'],
            // Common
            ['common.new-item-link'],
            ['common.code'],
            ['common.description'],
            ['common.active'],
            ['common.project_optional'],
            ['common.select'],
            // Catalog keys
            ['catalog.updated_success'],
            ['catalog.created_success'],
            ['catalog.confirm_delete'],
            // Visibility keys
            ['items.visibility.label'],
            ['items.visibility.tenant'],
            ['items.visibility.project'],
            // Labor
            ['labor.new'],
            // Buttons
            ['buttons.save'],
            ['buttons.back'],
        ];
    }

    #[DataProvider('providerKeys')]
    public function testTranslationKeysExist(string $key): void
    {
        $root = __DIR__ . '/../../';

        $enRaw = Yaml::parseFile($root . 'translations/messages.en.yaml');
        $esRaw = Yaml::parseFile($root . 'translations/messages.es.yaml');

        $this->assertIsArray($enRaw, 'messages.en.yaml should parse to an array');
        $this->assertIsArray($esRaw, 'messages.es.yaml should parse to an array');

        $en = self::flattenKeys($enRaw);
        $es = self::flattenKeys($esRaw);

        $foundInEn = isset($en[$key]);
        $foundInEs = isset($es[$key]);

        $this->assertTrue(
            $foundInEn || $foundInEs,
            "Translation key '$key' not found in EN or ES files"
        );
    }
}
