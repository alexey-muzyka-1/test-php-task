<?php

declare(strict_types=1);

namespace Required;

use App\Core\Domain\Entity\UserStatus;
use App\DataFixtures\RequiredFixture;
use Doctrine\Persistence\ObjectManager;

class LoadUserStatuses extends RequiredFixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (UserStatus::ALL as $status => $_label) {
            $status = new UserStatus($status);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
