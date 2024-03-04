<?php

declare(strict_types=1);

namespace App\DataFixtures\Demo;

use App\Core\Domain\Entity\Application;
use App\DataFixtures\DemoFixture;
use App\Shared\Domain\ValueObject\Url;
use Doctrine\Persistence\ObjectManager;

class LoadApplications extends DemoFixture
{
    public function load(ObjectManager $manager): void
    {
        $app1 = new Application('app', new Url('https://app.com'));
        $app2 = new Application('app', new Url('https://app2.com'));

        $manager->persist($app1);
        $manager->persist($app2);

        $manager->flush();
    }
}
