<?php

declare(strict_types=1);

namespace App\Core\Domain\Service;

class PasswordHasher
{
    public function __construct(private readonly int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
    }

    /**
     * @psalm-suppress InvalidArgument
     */
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
