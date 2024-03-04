<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use App\Core\Domain\Entity\Application;
use App\Core\Domain\Entity\User;
use App\Core\Domain\Entity\UserStatus;
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
        $user = $this->repo->findOneBy([
            'id' => $id,
            'application' => $application,
            'status.value' => UserStatus::STATUS_ACTIVE,
        ]);

        if (null === $user) {
            throw new EntityNotFoundException();
        }

        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
