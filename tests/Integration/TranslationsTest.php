<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class TranslationsTest extends TestCase
{
    /** @return array[] */
    public static function providerKeys(): array
    {
        return [
            ['new-item-link'],
            ['auth.reauth'],
            ['auth.reauth_prompt'],
            ['auth.confirm'],
        ];
    }

    #[DataProvider('providerKeys')]
    public function testTranslationKeysExist(string $key): void
    {
        $root = __DIR__ . '/../../';
        $en = @file_get_contents($root . 'translations/messages.en.yaml');
        $es = @file_get_contents($root . 'translations/messages.es.yaml');

        $this->assertNotFalse($en, 'messages.en.yaml should be readable');
        $this->assertNotFalse($es, 'messages.es.yaml should be readable');

        $foundInEn = strpos($en, $key) !== false;
        $foundInEs = strpos($es, $key) !== false;

        $this->assertTrue($foundInEn || $foundInEs, "Translation key '$key' not found in EN or ES files");
    }
}
