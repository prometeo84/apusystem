<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class QuotaTest extends TestCase
{
    public function testLimitTranslationKeysExist(): void
    {
        $root = __DIR__ . '/../../';
        $en = @file_get_contents($root . 'translations/messages.en.yaml');
        $es = @file_get_contents($root . 'translations/messages.es.yaml');

        $this->assertNotFalse($en);
        $this->assertNotFalse($es);

        $required = ['project.limit_reached', 'project.limit_near', 'user.limit_near'];
        foreach ($required as $k) {
            $this->assertTrue(strpos($en, $k) !== false || strpos($es, $k) !== false, "Missing translation key $k in EN or ES");
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
