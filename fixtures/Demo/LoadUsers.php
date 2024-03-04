<?php

declare(strict_types=1);

namespace App\DataFixtures\Demo;

use App\Core\Domain\Entity\Application;
use App\Core\Domain\Entity\User;
use App\Core\Domain\Service\PasswordHasher;
use App\Core\Domain\ValueObject\Name;
use App\DataFixtures\DemoFixture;
use App\Shared\Domain\ValueObject\Url;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadUsers extends DemoFixture implements DependentFixtureInterface
{
    private const DEFAULT_PASSWORD = '123123';

    public function __construct(
        private readonly PasswordHasher $hasher,
    ) {
    }

    public function getDependencies(): array
    {
        return [
            LoadApplications::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $application = $this->getReference('app1');

        $user1 = new User(
            $application,
            'test@mail.com',
            $this->hasher->hash(self::DEFAULT_PASSWORD),
            new Name('Bobby', 'Dobby')
        );

        $blocked = new User(
            $application,
            'blocked@mail.com',
            $this->hasher->hash(self::DEFAULT_PASSWORD),
            new Name('Bobbys', 'Dobbys')
        );

        $blocked->block();

        $manager->persist($user1);
        $manager->persist($blocked);

        $manager->flush();
    }
}
