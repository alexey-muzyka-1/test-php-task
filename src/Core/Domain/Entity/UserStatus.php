<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Shared\Domain\Lookup\Lookup;
use App\Shared\Domain\Lookup\LookupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LookupRepository::class, readOnly: true)]
#[ORM\Table(name: 'user_statuses')]
#[ORM\Cache(region: 'lookup_table')]
class UserStatus extends Lookup
{
    public const ALL = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_BLOCKED => 'Blocked',
    ];
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    public static function inActive(): self
    {
        return new self(self::STATUS_ACTIVE);
    }

    public static function inBlocked(): self
    {
        return new self(self::STATUS_BLOCKED);
    }

    public function isInActive(): bool
    {
        return $this->isEqualTo(self::STATUS_ACTIVE);
    }

    public function isInBlocked(): bool
    {
        return $this->isEqualTo(self::STATUS_BLOCKED);
    }
}
