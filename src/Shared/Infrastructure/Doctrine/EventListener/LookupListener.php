<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\EventListener;

use App\Shared\Domain\Lookup\LookupInterface;
use App\Shared\Domain\Lookup\LookupRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Event\LifecycleEventArgs;

final class LookupListener
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->handleEntity($args->getObject(), $args->getObjectManager());
    }

    public function preFlush(PreFlushEventArgs $args): void
    {
        $this->handle($args->getObjectManager());
    }

    private function handle(EntityManagerInterface $em): void
    {
        foreach ($em->getUnitOfWork()->getIdentityMap() as $entities) {
            foreach ($entities as $entity) {
                if (null === $entity) {
                    continue;
                }

                $this->handleEntity($entity, $em);
            }
        }
    }

    private function handleEntity(object $entity, EntityManagerInterface $em): void
    {
        if ($entity instanceof LookupInterface) {
            return;
        }

        $metadata = $em->getClassMetadata($entity::class);

        foreach ($metadata->getAssociationMappings() as $fieldName => $associationMapping) {
            if (!$metadata->isSingleValuedAssociation($fieldName)) {
                continue;
            }

            $reflField = $metadata->reflFields[$fieldName] ?? null;

            if (null === $reflField) {
                continue;
            }

            /** @var object|null $lookup */
            $lookup = $reflField->getValue($entity);

            if (null === $lookup) {
                continue;
            }

            if (!$this->isLookup($lookup, $em)) {
                continue;
            }

            /** @var LookupInterface $lookup */
            if (!$this->isNew($lookup, $em)) {
                continue;
            }

            $repository = $em->getRepository($lookup::class);

            if (!$repository instanceof LookupRepositoryInterface) {
                continue;
            }

            $managedLookup = $repository->get($lookup);

            $reflField->setValue($entity, $managedLookup);
        }
    }

    private function isLookup(object $entity, EntityManagerInterface $em): bool
    {
        return $em->getClassMetadata($entity::class)->reflClass->implementsInterface(LookupInterface::class);
    }

    private function isNew(object $entity, EntityManagerInterface $em): bool
    {
        return UnitOfWork::STATE_NEW === $em->getUnitOfWork()->getEntityState($entity);
    }
}
