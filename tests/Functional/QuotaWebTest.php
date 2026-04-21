<?php

namespace App\Tests\Functional;

use App\Entity\Tenant;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuotaWebTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }
    public function testCreateButtonsHiddenWhenLimitsReached(): void
    {
        self::ensureKernelShutdown();
        // Boot kernel and create a KernelBrowser manually (avoid test.client requirement)
        $kernel = static::bootKernel(['environment' => 'test']);
        $client = new \Symfony\Bundle\FrameworkBundle\KernelBrowser($kernel);

        // Get entity manager
        $container = $kernel->getContainer();

        // If session factory or test client support is not available in this environment, skip the test.
        if (!$container->has('session.factory')) {
            $this->markTestSkipped('Session factory not available in this environment; skipping functional authentication test.');
        }
        $em = $container->get('doctrine')->getManager();

        // Ensure schema exists (create in test DB)
        $meta = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($meta)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
            try {
                $schemaTool->dropSchema($meta);
            } catch (\Throwable $e) {
                // ignore
            }
            $schemaTool->createSchema($meta);
        }

        // Create tenant with strict limits
        $tenant = new Tenant();
        $tenant->setName('Test Tenant');
        $tenant->setSlug('test-tenant-' . random_int(1000, 9999));
        $tenant->setMaxUsers(1);
        $tenant->setMaxProjects(0); // block project creation
        // Persist tenant
        $em->persist($tenant);

        // Create admin user
        $user = new User();
        $user->setEmail('admin@example.test');
        $user->setUsername('admin');
        $user->setFirstName('Admin');
        $user->setLastName('Test');
        $user->setTenant($tenant);
        $user->setRole('super_admin');
        // Bypass full password complexity for tests
        $user->setPassword('not_relevant');
        $em->persist($user);

        $em->flush();

        // Log in the user in the test client
        $client->loginUser($user);

        // Dashboard should render and new project buttons should be disabled
        $crawler = $client->request('GET', '/dashboard');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $html = $client->getResponse()->getContent();
        $this->assertStringContainsString('project.limit_reached', $html, 'Dashboard should include project limit warning key (translated or queued)');

        // Projects index: new project button should be disabled (no href to create)
        $crawler = $client->request('GET', '/projects');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $html = $client->getResponse()->getContent();
        // Button renders with disabled class or without link
        $this->assertTrue(str_contains($html, 'class="disabled"') || !str_contains($html, 'href="/projects/create"'), 'New project button must be disabled or not link to create');

        // Items (materials/labor) creation should still be allowed by default (max items not set)
        $crawler = $client->request('GET', '/items');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $html = $client->getResponse()->getContent();
        $this->assertStringContainsString('rubro.new', $html, 'Items page should contain rubro.new translation key in template');

        // Cleanup created fixtures
        $em->remove($user);
        $em->remove($tenant);
        $em->flush();
    }
}
