<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use App\Core\Domain\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ApplicationRepository
{
    /**
     * @var EntityRepository<Application>
     */
    private EntityRepository $repo;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Application::class);
    }

    public function findOneBy(array $criteria): ?Application
    {
        return $this->repo->findOneBy($criteria);
    }

    public function add(Application $application): void
    {
        $this->em->persist($application);
        $this->em->flush();
    }
}
