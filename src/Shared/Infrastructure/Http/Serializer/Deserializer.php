<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Deserializer
{
    public function __construct(
        private readonly SerializerInterface $deserializer,
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $type
     *
     * @return T
     */
    public function deserializeJson(mixed $data, string $type): object
    {
        /* @var T */
        return $this->deserializer->deserialize($data, $type, JsonEncoder::FORMAT, [
            DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true,
            AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        ]);
    }
}
