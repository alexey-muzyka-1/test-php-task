<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Types;

use App\Shared\Domain\ValueObject\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UrlType extends StringType
{
    public const NAME = 'url';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Url ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Url
    {
        /* @phpstan-ignore-next-line */
        return null !== $value ? new Url((string) $value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
