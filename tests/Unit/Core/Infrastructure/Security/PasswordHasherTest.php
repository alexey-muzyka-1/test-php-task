<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Infrastructure\Security;

use App\Core\Domain\Service\PasswordHasher;
use PHPUnit\Framework\TestCase;

class PasswordHasherTest extends TestCase
{
    public function test_it_hash_correct(): void
    {
        $hasher = new PasswordHasher(16);
        $paswd1 = $hasher->hash('password');

        self::assertTrue($hasher->validate('password', $paswd1));
    }
}
