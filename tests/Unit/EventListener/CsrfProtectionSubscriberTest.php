<?php

namespace App\Tests\Unit\EventListener;

use App\EventListener\CsrfProtectionSubscriber;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * UC-06: CsrfProtectionSubscriber
 * Cubre: exclusión de rutas, validación de token por campo y header
 */
class CsrfProtectionSubscriberTest extends TestCase
{
    private CsrfTokenManagerInterface&MockObject $csrfManager;
    private CsrfProtectionSubscriber $subscriber;

    protected function setUp(): void
    {
        $this->csrfManager = $this->createMock(CsrfTokenManagerInterface::class);
        $this->subscriber  = new CsrfProtectionSubscriber($this->csrfManager);
    }

    private function makeEvent(string $path, string $method, array $post = [], array $headers = []): RequestEvent
    {
        $request = Request::create($path, $method, $post);
        foreach ($headers as $key => $value) {
            $request->headers->set($key, $value);
        }

        $kernel = $this->createMock(HttpKernelInterface::class);
        return new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);
    }

    // ---- GET requests are ignored ----

    #[Test]
    public function getRequestIsNotChecked(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/profile/edit', 'GET');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse()); // no 403 set
    }

    // ---- Excluded paths ----

    #[Test]
    public function loginPostIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/login', 'POST');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function logoutPostIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/logout', 'POST');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function webauthnLoginStartIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/webauthn/login/start', 'POST');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function symfonyProfilerPathIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/_profiler/abc', 'POST');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function apiPathIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/api/v2/auth/login', 'POST');
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function jsonContentTypeIsExcluded(): void
    {
        $this->csrfManager->expects($this->never())->method('isTokenValid');

        $event = $this->makeEvent('/profile/edit', 'POST', [], [
            'Content-Type' => 'application/json',
        ]);
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    // ---- Token validation ----

    #[Test]
    public function postWithValidTokenFromFieldPasses(): void
    {
        $this->csrfManager
            ->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(true);

        $event = $this->makeEvent('/profile/edit', 'POST', ['_token' => 'valid_token']);
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function postWithValidTokenFromHeaderPasses(): void
    {
        $this->csrfManager
            ->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(true);

        $event = $this->makeEvent('/webauthn/revoke/5', 'POST', [], [
            'X-CSRF-Token' => 'valid_csrf_header',
        ]);
        $this->subscriber->onRequest($event);

        $this->assertNull($event->getResponse());
    }

    #[Test]
    public function postWithoutTokenReturns403(): void
    {
        $this->csrfManager
            ->method('isTokenValid')
            ->willReturn(false);

        $event = $this->makeEvent('/admin/users/create', 'POST');
        $this->subscriber->onRequest($event);

        $response = $event->getResponse();
        $this->assertNotNull($response);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    #[Test]
    public function postWithInvalidTokenReturns403(): void
    {
        $this->csrfManager
            ->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(false);

        $event = $this->makeEvent('/admin/users/create', 'POST', ['_token' => 'wrong_token']);
        $this->subscriber->onRequest($event);

        $response = $event->getResponse();
        $this->assertNotNull($response);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    // ---- getSubscribedEvents ----

    #[Test]
    public function subscribedToKernelRequestWithPriority10(): void
    {
        $events = CsrfProtectionSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(KernelEvents::REQUEST, $events);
        $this->assertSame(['onRequest', 10], $events[KernelEvents::REQUEST]);
    }
}
