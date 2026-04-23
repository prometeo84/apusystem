<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class QuotaTest extends TestCase
{
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

    public function testLimitTranslationKeysExist(): void
    {
        $root = __DIR__ . '/../../';
        $en = self::flattenKeys(Yaml::parseFile($root . 'translations/messages.en.yaml'));
        $es = self::flattenKeys(Yaml::parseFile($root . 'translations/messages.es.yaml'));

        $required = ['project.limit_reached', 'project.limit_near', 'user.limit_near'];
        foreach ($required as $k) {
            $this->assertTrue(
                isset($en[$k]) || isset($es[$k]),
                "Missing translation key $k in EN or ES"
            );
        }
    }

    public function testProjectControllerContainsLimitCheck(): void
    {
        $p = __DIR__ . '/../../src/Controller/ProjectController.php';
        $txt = @file_get_contents($p);
        $this->assertNotFalse($txt, 'ProjectController.php should be readable');

        $this->assertStringContainsString('getMaxProjects', $txt, 'ProjectController should call getMaxProjects to enforce limits');
        $this->assertStringContainsString("project.limit_reached", $txt, 'ProjectController should addFlash project.limit_reached when blocked');
    }
}
