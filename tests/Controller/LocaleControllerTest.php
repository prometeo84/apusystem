<?php

namespace App\Tests\Controller;

use App\Controller\LocaleController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class LocaleControllerTest extends TestCase
{
    private function makeController(): LocaleController
    {
        // Create a small subclass to override framework-dependent helpers
        return new class extends LocaleController {
            public function __construct() {}
            protected function redirect(string $url, int $status = 302): RedirectResponse
            {
                return new RedirectResponse($url, $status);
            }
            protected function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse
            {
                // Minimal mapping for tests
                if ($route === 'app_login') {
                    return new RedirectResponse('/login', $status);
                }
                return new RedirectResponse('/', $status);
            }
        };
    }

    public function testRedirectsToAbsoluteRefererOnSameHost()
    {
        $controller = $this->makeController();

        $session = new Session(new MockArraySessionStorage());
        $request = Request::create('/locale/es', 'GET', [], [], [], [
            'HTTP_REFERER' => 'http://localhost/dashboard?foo=bar'
        ]);
        $request->setSession($session);

        $resp = $controller->setLocale($request, 'es');
        $this->assertInstanceOf(RedirectResponse::class, $resp);
        $this->assertEquals('/dashboard?foo=bar', $resp->getTargetUrl());
    }

    public function testRedirectsToRelativeReferer()
    {
        $controller = $this->makeController();

        $session = new Session(new MockArraySessionStorage());
        $request = Request::create('/set-locale/en', 'GET', [], [], [], [
            'HTTP_REFERER' => '/projects?page=2'
        ]);
        $request->setSession($session);

        $resp = $controller->setLocale($request, 'en');
        $this->assertInstanceOf(RedirectResponse::class, $resp);
        $this->assertEquals('/projects?page=2', $resp->getTargetUrl());
    }

    public function testExternalRefererRedirectsToLogin()
    {
        $controller = $this->makeController();

        $session = new Session(new MockArraySessionStorage());
        $request = Request::create('/locale/es', 'GET', [], [], [], [
            'HTTP_REFERER' => 'https://evil.example.com/malicious'
        ]);
        $request->setSession($session);

        $resp = $controller->setLocale($request, 'es');
        $this->assertInstanceOf(RedirectResponse::class, $resp);
        $this->assertEquals('/login', $resp->getTargetUrl());
    }
}
