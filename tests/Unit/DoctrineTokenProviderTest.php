<?php

namespace App\Tests\Unit;

use App\Security\DoctrineTokenProvider;
use App\Entity\User;
use App\Entity\RememberMeToken;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentTokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DoctrineTokenProviderTest extends TestCase
{
    public function testCreateNewTokenPersistsEntity()
    {
        $em = $this->createMock(EntityManagerInterface::class);

        // Expect persist called with RememberMeToken instance and flush called once
        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(RememberMeToken::class));

        $em->expects($this->once())
            ->method('flush');

        $user = new User();
        $user->setEmail('u@example.com');
        $user->setUsername('u');

        $userProvider = $this->createMock(UserProviderInterface::class);
        $userProvider->expects($this->once())
            ->method('loadUserByIdentifier')
            ->with('u@example.com')
            ->willReturn($user);

        $tokenStub = new class implements PersistentTokenInterface {
            private string $username;
            private string $series;
            private string $value;
            private \DateTimeInterface $dt;
            public function __construct()
            {
                $this->username = 'u@example.com';
                $this->series = 'S123';
                $this->value = 'TVAL';
                $this->dt = new \DateTime();
            }
            public function getClass(): string
            {
                return self::class;
            }
            public function getUsername(): string
            {
                return $this->username;
            }
            public function getUserIdentifier(): string
            {
                return $this->username;
            }
            public function getSeries(): string
            {
                return $this->series;
            }
            public function getTokenValue(): string
            {
                return $this->value;
            }
            public function getLastUsed(): \DateTime
            {
                return new \DateTime();
            }
        };

        $provider = new DoctrineTokenProvider($em, $userProvider);
        $provider->createNewToken($tokenStub);
    }

    public function testLoadTokenBySeriesReturnsPersistentToken()
    {
        $em = $this->createMock(EntityManagerInterface::class);

        $user = new User();
        $user->setEmail('x@example.com');
        $user->setUsername('x');

        $remember = new RememberMeToken($user, 'SER', 'VAL', new \DateTime());

        $repo = $this->createMock(\Doctrine\ORM\EntityRepository::class);
        $repo->method('findOneBy')->willReturn($remember);
        $em->method('getRepository')->willReturn($repo);

        $userProvider = $this->createMock(UserProviderInterface::class);

        $provider = new DoctrineTokenProvider($em, $userProvider);
        $result = $provider->loadTokenBySeries('SER');

        $this->assertInstanceOf(PersistentTokenInterface::class, $result);
    }
}
