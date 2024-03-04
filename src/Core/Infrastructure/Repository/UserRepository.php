<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use App\Core\Domain\Entity\Application;
use App\Core\Domain\Entity\User;
use App\Shared\Domain\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $repo;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(User::class);
    }

    public function getActive(string $id, Application $application): User
    {
        $user = $this->findApplicationUser($id, $application);

        if (null === $user || !$user->isActive()) {
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }

    public function findApplicationUser(string $id, Application $application): ?User
    {
        return $this->repo->findOneBy([
            'id' => $id,
            'application' => $application,
        ]);
    }

    public function isRegisteredForApplicationByEmail(string $email, Application $application): ?User
    {
        return $this->repo->findOneBy([
            'email' => $email,
            'application' => $application,
        ]);
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
