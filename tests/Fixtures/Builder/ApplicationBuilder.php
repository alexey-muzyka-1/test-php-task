<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Core\Domain\Entity\Application;
use App\Shared\Domain\ValueObject\Url;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationBuilder
{
    protected Application $object;

    private function __construct(string $name, Url $url)
    {
        $this->object = new Application($name, $url);
    }

    public static function createAny(): self
    {
        return new self('aaaa', new Url('https://aaaa.com'));
    }

    public function build(EntityManagerInterface $em): Application
    {
        $em->persist($this->object);

        return $this->object;
    }

    public function buildForUnitTest(): Application
    {
        return $this->object;
    }
}
