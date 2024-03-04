<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Api\Request;

use App\Shared\Infrastructure\Api\Request\BaseRequest;

class UpdateUserRequest extends BaseRequest
{
    public ?string $firstName = null;

    public ?string $lastName = null;
}
