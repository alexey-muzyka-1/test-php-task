<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Api\Request;

use App\Shared\Infrastructure\Api\Request\BaseRequest;

class CreateUserRequest extends BaseRequest
{
    public string $email;

    public string $password;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $parentId = null;
}
