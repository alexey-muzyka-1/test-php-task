<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use DomainException;

class Url
{
    private string $value;

    public function __construct(string $ip)
    {
        if (false === filter_var($ip, FILTER_VALIDATE_URL)) {
            throw new DomainException('Invalid Url: ' . $ip);
        }

        $this->value = $ip;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
