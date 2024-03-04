<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\ValueObject\Name;
use App\Shared\Domain\Entity\Trait\Timestamps;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'unique_users_application_email_address', columns: ['application_id', 'email'])]
#[ORM\Entity]
class User
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    private string $password;

    #[ORM\ManyToOne(targetEntity: Application::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Application $application;

    #[ORM\ManyToOne(targetEntity: UserStatus::class)]
    #[ORM\JoinColumn(nullable: false)]
    private UserStatus $status;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $blockedAt = null;
}
