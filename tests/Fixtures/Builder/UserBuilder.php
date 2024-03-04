<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Core\Domain\Entity\Application;
use App\Core\Domain\Entity\User;
use App\Core\Domain\ValueObject\Name;
use App\Tests\Fixtures\StringHelper;
use Doctrine\ORM\EntityManagerInterface;

class UserBuilder
{
    protected User $object;

    private function __construct(Application $application, string $email, Name $name, ?User $parent = null)
    {
        $this->object = new User($application, $email, 'password', $name, $parent);
    }

    public static function createAny(Application $application, ?User $parent = null): self
    {
        return new self($application, StringHelper::randomString(6) . '@mail.com', new Name('Mike', 'Mike'), $parent);
    }

    public function build(EntityManagerInterface $em): User
    {
        $em->persist($this->object);

        return $this->object;
    }

    public function buildForUnitTest(): User
    {
        return $this->object;
    }
}
