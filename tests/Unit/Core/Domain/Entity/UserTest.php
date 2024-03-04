<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain\Entity;

use App\Tests\Fixtures\Builder\ApplicationBuilder;
use App\Tests\Fixtures\Builder\UserBuilder;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_it_blocks_user(): void
    {
        $application = ApplicationBuilder::createAny()->buildForUnitTest();
        $user = UserBuilder::createAny($application)->buildForUnitTest();

        self::assertTrue($user->isActive());

        $user->block();

        self::assertFalse($user->isActive());
        self::assertInstanceOf(DateTimeImmutable::class, $user->getBlockedAt());

        // Blocking again should throw an exception
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('User already blocked');
        $user->block();
    }

    public function test_it_correctly_converts_user_to_array(): void
    {
        $application = ApplicationBuilder::createAny()->buildForUnitTest();
        $user = UserBuilder::createAny($application)->buildForUnitTest();

        $expectedArray = [
            'email' => $user->getEmail(),
            'name' => 'Mike Mike',
            'parent' => null,
        ];

        self::assertSame($expectedArray, $user->toArray());

        $childUser = UserBuilder::createAny($application, $user)->buildForUnitTest();

        $expectedArray2 = [
            'email' => $childUser->getEmail(),
            'name' => 'Mike Mike',
            'parent' => $user->getId(),
        ];

        self::assertSame($expectedArray2, $childUser->toArray());
    }
}
