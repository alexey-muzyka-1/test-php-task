<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class Name
{
    public const NAME_MIN_LENGTH = 2;
    public const NAME_MAX_LENGTH = 15;
    private const REGEX_FIRST_AND_LAST_NAME = '/^[A-Za-z\x{0400}-\x{04FF}\']+$/u';

    #[ORM\Column(type: 'string', length: Name::NAME_MAX_LENGTH, nullable: true)]
    private ?string $first;

    #[ORM\Column(type: 'string', length: Name::NAME_MAX_LENGTH, nullable: true)]
    private ?string $last;

    public function __construct(?string $first, ?string $last)
    {
        $this->validateFirstName($first);
        $this->first = self::ucFirst($first);

        $this->validateLastName($last);
        $this->last = self::ucFirst($last);
    }

    public static function emptyName(): self
    {
        return new self(null, null);
    }

    public function isNameFilled(): bool
    {
        return null !== $this->first && null !== $this->last;
    }

    public function getFirst(): ?string
    {
        return $this->first;
    }

    public function getLast(): ?string
    {
        return $this->last;
    }

    public function getFullName(): string
    {
        return $this->first . ' ' . $this->getLast();
    }

    private function validateFirstName(?string $firstName): void
    {
        if (null === $firstName) {
            return;
        }

        Assert::minLength($firstName, self::NAME_MIN_LENGTH, 'First name too short');
        Assert::maxLength($firstName, self::NAME_MAX_LENGTH, 'First name too long');
        Assert::regex($firstName, self::REGEX_FIRST_AND_LAST_NAME, 'First name must contain only letters');
    }

    private function validateLastName(?string $lastName): void
    {
        if (null === $lastName) {
            return;
        }

        Assert::minLength($lastName, self::NAME_MIN_LENGTH, 'Last name too short');
        Assert::maxLength($lastName, self::NAME_MAX_LENGTH, 'Last name too long');
        Assert::regex($lastName, self::REGEX_FIRST_AND_LAST_NAME, 'Last name must contain only letters');
    }

    private static function ucFirst(?string $string, string $encoding = 'UTF-8'): ?string
    {
        if (null === $string) {
            return null;
        }

        return mb_strtoupper(mb_substr($string, 0, 1, $encoding), $encoding) .
            mb_substr($string, 1, null, $encoding);
    }
}
