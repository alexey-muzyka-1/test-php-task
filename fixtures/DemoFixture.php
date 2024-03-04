<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

abstract class DemoFixture extends Fixture implements FixtureGroupInterface
{
    final public static function getGroups(): array
    {
        return ['Demo'];
    }
}
