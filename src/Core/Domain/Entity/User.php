<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\ValueObject\Name;
use App\Shared\Domain\Entity\Trait\Timestamps;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Ramsey\Uuid\Uuid;

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

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childSkills')]
    private ?self $parent = null;

    #[ORM\ManyToOne(targetEntity: UserStatus::class)]
    #[ORM\JoinColumn(nullable: false)]
    private UserStatus $status;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $blockedAt = null;

    public function __construct(
        Application $application,
        string $email,
        string $password,
        Name $name,
        ?self $parent = null
    ) {
        if (null !== $parent && $parent->isChild()) {
            throw new DomainException('Cannot use nested user as parent.');
        }

        $this->id = Uuid::uuid4()->toString();

        $this->application = $application;

        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->status = UserStatus::inActive();
        $this->parent = $parent;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->status->isInActive();
    }

    public function isChild(): bool
    {
        return null !== $this->parent;
    }

    public function update(Name $name): void
    {
        $this->name = $name;

        $this->updatedAt = new DateTimeImmutable();
    }

    public function block(): void
    {
        if ($this->status->isInBlocked()) {
            throw new DomainException('User already blocked');
        }

        $this->status = UserStatus::inBlocked();
        $this->blockedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name->getFullName(),
            'parent' => $this->parent?->getId(),
        ];
    }

    public function getBlockedAt(): ?DateTimeImmutable
    {
        return $this->blockedAt;
    }
}
