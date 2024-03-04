<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\ArgumetResolver;

use App\Shared\Domain\Validator\ValidatorInterface;
use App\Shared\Infrastructure\Api\Request\BaseRequest;
use App\Shared\Infrastructure\Http\Serializer\Deserializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class RequestObjectResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly Deserializer $denormalizer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->supports($argument)) {
            return [];
        }

        /** @var class-string $type */
        $type = $argument->getType();
        $dto = $this->denormalizer->deserializeJson($request->getContent(), $type);

        $this->validator->validate($dto);

        return [$dto];
    }

    private function supports(ArgumentMetadata $argument): bool
    {
        return is_subclass_of((string) $argument->getType(), BaseRequest::class);
    }
}
