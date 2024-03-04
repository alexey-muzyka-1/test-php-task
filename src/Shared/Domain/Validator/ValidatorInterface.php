<?php

declare(strict_types=1);

namespace App\Shared\Domain\Validator;

interface ValidatorInterface
{
    public function validate(object $object): void;
}
