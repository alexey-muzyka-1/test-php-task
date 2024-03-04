<?php

declare(strict_types=1);

namespace App\Shared\Domain\Lookup;

interface LookupRepositoryInterface
{
    public function get(LookupInterface $lookup): LookupInterface;
}
