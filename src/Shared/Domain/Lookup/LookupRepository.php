<?php

declare(strict_types=1);

namespace App\Shared\Domain\Lookup;

use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Lookup>
 */
class LookupRepository extends EntityRepository implements LookupRepositoryInterface
{
    public function get(LookupInterface $lookup): LookupInterface
    {
        $qb = $this->createQueryBuilder('l');

        $qb->where('l.sysName = :sysName')
            ->setParameter('sysName', $lookup->getSysName());

        /** @var LookupInterface $lookup */
        $lookup = $qb->getQuery()->getSingleResult();

        return $lookup;
    }
}
