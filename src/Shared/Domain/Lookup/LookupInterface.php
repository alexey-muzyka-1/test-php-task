<?php

declare(strict_types=1);

namespace App\Shared\Domain\Lookup;

interface LookupInterface
{
    public function getSysName(): string;
}
