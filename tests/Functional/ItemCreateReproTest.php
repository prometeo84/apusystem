<?php

namespace App\Tests\Functional;

use App\Entity\Tenant;
use App\Entity\User;
use App\Entity\Projects;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemCreateReproTest extends WebTestCase
{
    private $client;
    private $em;

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->em = static::getContainer()->get('doctrine')->getManager();
    }

    #[Test]
    public function reproNameInvalidError(): void
    {
        // Create tenant, admin user and a project P01
        $tenant = new Tenant();
        $tenant->setName('T1');
        $tenant->setSlug('t1-' . bin2hex(random_bytes(3)));
        $this->em->persist($tenant);

        $user = new User();
        $user->setEmail('admin@example.test');
        $user->setUsername('admin');
        $user->setFirstName('A');
        $user->setLastName('B');
        $user->setTenant($tenant);
        $user->setRole('admin');
        $user->setPassword('not_hashed');
        $this->em->persist($user);

        $project = new Projects();
        $project->setTenant($tenant);
        $project->setCreatedBy($user);
        $project->setName('P01');
        $project->setCode('P01');
        $project->setStatus('planificacion');
        $this->em->persist($project);

        $this->em->flush();

        // Authenticate
        $this->client->loginUser($user);

        // Fetch form to get CSRF token
        $crawler = $this->client->request('GET', '/items/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $token = $crawler->filter('input[name="_token"]')->attr('value');

        $post = [
            '_token' => $token,
            'code' => 'R-001',
            'name' => 'Provisión eh instalación de porcelanato ALLEGHENCY 20X120cm. (Incl. Insumos)',
            'description' => 'Provisión eh instalación de porcelanato ALLEGHENCY 20X120cm. (Incluye Insumos)',
            'unit' => 'm2',
            'visibility' => 'project',
            'project_id' => (string)$project->getId(),
        ];

        $this->client->request('POST', '/items/create', $post);
        $resp = $this->client->getResponse();
        // On success controller redirects to index (302). If validation fails it returns 200 with errors.
        $this->assertTrue(in_array($resp->getStatusCode(), [301, 302, 303]), 'Expected redirect on successful create');
        $this->assertStringNotContainsString('name.invalid', $resp->getContent());
    }
}
