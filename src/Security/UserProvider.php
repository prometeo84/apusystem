<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new \InvalidArgumentException('Invalid user class');
        }

        $refreshedUser = $this->em->getRepository(User::class)->find($user->getId());
        
        if (!$refreshedUser) {
            throw new UserNotFoundException();
        }

        return $refreshedUser;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :identifier')
            ->orWhere('u.username = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
