<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use DomainException;

class EntityNotFoundException extends DomainException
{
    public function __construct(string $message = 'Required data not found.')
    {
        parent::__construct($message);
    }
}
