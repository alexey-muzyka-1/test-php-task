<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Domain\Exception\ValidationException;
use App\Shared\Domain\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidator;

class Validator implements ValidatorInterface
{
    public function __construct(
        private readonly BaseValidator $validator
    ) {
    }

    public function validate(object $object): void
    {
        $violations = $this->validator->validate($object);

        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}
