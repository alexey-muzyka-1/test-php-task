<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain\ValueObject;

use App\Core\Domain\ValueObject\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function test_first_name_validation(): void
    {
        $name = $this->createName('first', 'last');
        self::assertSame('First', $name->getFirst());
        self::assertSame('Last', $name->getLast());

        $name = $this->createName('O\'Kon', 'O\'Ken');
        self::assertSame('O\'Kon', $name->getFirst());
        self::assertSame('O\'Ken', $name->getLast());

        $name = $this->createName('вася', 'пУПКИГН');
        self::assertSame('Вася', $name->getFirst());
        self::assertSame('ПУПКИГН', $name->getLast());
    }

    public function test_first_name_too_short(): void
    {
        $this->expectExceptionMessage('First name too short');
        $name = $this->createName('f', 'last');
    }

    public function test_first_name_too_long(): void
    {
        $this->expectExceptionMessage('First name too long');
        $name = $this->createName('firstNameToLongQ', 'last');
    }

    public function test_first_name_too_regex(): void
    {
        $this->expectExceptionMessage('First name must contain only letters');
        $name = $this->createName('first@', 'last');

        $this->expectExceptionMessage('First name must contain only letters');
        $name = $this->createName('first1', 'last');
    }

    public function test_last_name_too_short(): void
    {
        $this->expectExceptionMessage('Last name too short');
        $name = $this->createName('first', 'l');
    }

    public function test_last_name_too_long(): void
    {
        $this->expectExceptionMessage('Last name too long');
        $name = $this->createName('first', 'lastNameToLongQQ');
    }

    public function test_last_name_too_regex(): void
    {
        $this->expectExceptionMessage('Last name must contain only letters');
        $name = $this->createName('first', 'last!');

        $this->expectExceptionMessage('Last name must contain only letters');
        $name = $this->createName('first', '1last');
    }

    public function test_allow_empty_name(): void
    {
        $name = $this->createName(null, null);

        self::assertNull($name->getFirst());
        self::assertNull($name->getLast());
    }

    private function createName(?string $first, ?string $last): Name
    {
        return new Name($first, $last);
    }
}
