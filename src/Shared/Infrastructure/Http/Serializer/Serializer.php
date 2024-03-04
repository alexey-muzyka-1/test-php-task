<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface as BaseSerializer;

class Serializer
{
    public function __construct(
        private readonly BaseSerializer $deserializer,
    ) {
    }

    public function serializeJson(mixed $data): string
    {
        return $this->deserializer->serialize($data, JsonEncoder::FORMAT);
    }
}
