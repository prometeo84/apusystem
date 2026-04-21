<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class ReauthCsrfTest extends TestCase
{
    public function testReauthTemplateContainsCsrfToken(): void
    {
        $p = __DIR__ . '/../../templates/security/reauth.html.twig';
        $txt = @file_get_contents($p);
        $this->assertNotFalse($txt, 'reauth.html.twig should be readable');

        $this->assertStringContainsString("name=\"_token\"", $txt, 'Form should include _token hidden input');
        $this->assertStringContainsString("csrf_token('submit')", $txt, 'Template should generate csrf_token("submit")');
    }
}
