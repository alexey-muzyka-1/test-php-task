<?php

declare(strict_types=1);

namespace App\Shared\Domain\Lookup;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\MappedSuperclass]
abstract class Lookup implements LookupInterface
{
    public const SYSNAME_MAX_LENGTH = 25;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(type: 'string', length: Lookup::SYSNAME_MAX_LENGTH, unique: true)]
    private string $sysName;

    public function __construct(string $sysName)
    {
        $this->sysName = $sysName;
        Assert::maxLength($sysName, self::SYSNAME_MAX_LENGTH);
    }

    public function __toString(): string
    {
        return $this->sysName;
    }

    final public function getId(): int
    {
        return $this->id;
    }

    public function getSysName(): string
    {
        return $this->sysName;
    }

    protected function isEqualTo(string $sysName): bool
    {
        return $this->sysName === $sysName;
    }
}
