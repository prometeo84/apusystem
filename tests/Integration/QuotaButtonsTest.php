<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class QuotaButtonsTest extends TestCase
{
    public function testTemplatesReceiveCanCreateFlags(): void
    {
        $controllers = [
            'src/Controller/DashboardController.php',
            'src/Controller/ProjectController.php',
            'src/Controller/AdminController.php',
            'src/Controller/APUController.php',
            'src/Controller/ItemController.php',
            'src/Controller/TemplateController.php',
        ];

        foreach ($controllers as $c) {
            $path = __DIR__ . '/../../' . $c;
            $this->assertFileExists($path, "Controller file $c should exist");
            $txt = file_get_contents($path);
            $this->assertNotFalse($txt);
        }

        // Check templates for conditional flags
        $templates = [
            'templates/dashboard/index.html.twig',
            'templates/projects/index.html.twig',
            'templates/admin/users.html.twig',
            'templates/apu/index.html.twig',
            'templates/items/index.html.twig',
            'templates/template/show.html.twig',
        ];

        foreach ($templates as $t) {
            $path = __DIR__ . '/../../' . $t;
            $this->assertFileExists($path, "Template $t must exist");
            $txt = file_get_contents($path);
            $this->assertNotFalse($txt);
        }

        // Static checks: ensure templates contain our can_create_* variables or disabled classes
        $this->assertStringContainsString('can_create_project', file_get_contents(__DIR__ . '/../../templates/dashboard/index.html.twig'));
        $this->assertStringContainsString('can_create_apu', file_get_contents(__DIR__ . '/../../templates/dashboard/index.html.twig'));
        $this->assertStringContainsString('can_create_user', file_get_contents(__DIR__ . '/../../templates/admin/users.html.twig'));
        $this->assertStringContainsString('can_create_item', file_get_contents(__DIR__ . '/../../templates/items/index.html.twig'));
    }
}
