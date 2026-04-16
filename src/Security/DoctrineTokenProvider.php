<?php

namespace App\Security;

use App\Entity\RememberMeToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentToken;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentTokenInterface;
use Symfony\Component\Security\Core\Authentication\RememberMe\TokenProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DoctrineTokenProvider implements TokenProviderInterface
{
    public function __construct(private EntityManagerInterface $em, private UserProviderInterface $userProvider) {}

    public function createNewToken(PersistentTokenInterface $token): void
    {
        // Extract username/user identifier from the token (compat across Symfony versions)
        if (method_exists($token, 'getUserIdentifier')) {
            $username = $token->getUserIdentifier();
        } elseif (method_exists($token, 'getUser')) {
            $username = $token->getUser();
        } elseif (method_exists($token, 'getUsername')) {
            $username = $token->getUsername();
        } else {
            throw new \RuntimeException('Cannot determine username from PersistentToken');
        }

        // Support both modern and legacy user provider method names
        if (method_exists($this->userProvider, 'loadUserByIdentifier')) {
            $user = $this->userProvider->loadUserByIdentifier($username);
        } else {
            $user = $this->userProvider->loadUserByUsername($username);
        }
        $entity = new RememberMeToken($user, $token->getSeries(), $token->getTokenValue(), $token->getLastUsed());
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function updateToken(string $series, string $tokenValue, \DateTimeInterface $lastUsed): void
    {
        $repo = $this->em->getRepository(RememberMeToken::class);
        $entity = $repo->findOneBy(['series' => $series]);
        if ($entity) {
            $entity->setTokenValue($tokenValue);
            $entity->setLastUsed($lastUsed);
            $this->em->flush();
        }
    }

    public function loadTokenBySeries(string $series): ?PersistentTokenInterface
    {
        $repo = $this->em->getRepository(RememberMeToken::class);
        $entity = $repo->findOneBy(['series' => $series]);
        if (!$entity) {
            return null;
        }
        return new PersistentToken(
            $entity->getUser()->getUserIdentifier(),
            $entity->getSeries(),
            $entity->getTokenValue(),
            $entity->getLastUsed()
        );
    }

    public function removeUserTokens(string $username): void
    {
        $repo = $this->em->getRepository(RememberMeToken::class);
        if (method_exists($this->userProvider, 'loadUserByIdentifier')) {
            $user = $this->userProvider->loadUserByIdentifier($username);
        } else {
            $user = $this->userProvider->loadUserByUsername($username);
        }
        $tokens = $repo->findBy(['user' => $user]);
        foreach ($tokens as $t) {
            $this->em->remove($t);
        }
        $this->em->flush();
    }

    public function deleteTokenBySeries(string $series): void
    {
        $repo = $this->em->getRepository(RememberMeToken::class);
        $entity = $repo->findOneBy(['series' => $series]);
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
        }
    }
}
