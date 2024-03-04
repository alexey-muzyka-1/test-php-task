<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Shared\Domain\Entity\Trait\Timestamps;
use App\Shared\Domain\ValueObject\Url;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Table(name: 'applications')]
#[ORM\Entity]
class Application
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'url')]
    private Url $url;

    #[ORM\Column(type: 'string', length: 255)]
    private string $apiKey;

    public function __construct(
        string $name,
        Url $url,
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->url = $url;
        $this->apiKey = Uuid::uuid6()->toString();

        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
