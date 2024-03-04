<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Api\Controller;

use App\Core\Domain\Service\PasswordHasher;
use App\Core\Domain\ValueObject\Name;
use App\Core\Infrastructure\Api\Request\CreateUserRequest;
use App\Core\Infrastructure\Repository\UserRepository;
use App\Shared\Infrastructure\Api\Controller\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/users', name: 'api.users.post', methods: ['POST'])]
class CreateUserAction extends AbstractAction
{
    public function __invoke(
        CreateUserRequest $data,
        Request $request,
        UserRepository $userRepository,
    ): JsonResponse {
        $application = $this->getMyApplication($request);

        if ($userRepository->isRegisteredForApplicationByEmail($data->email, $application)) {
            throw new \DomainException('User with this email already registered for the application');
        }

        $hasher = new PasswordHasher();

        $parent = null;

        if (null !== $data->parentId) {
            $parent = $userRepository->getActive($data->parentId, $application);
        }

        $user = $application->registerNewUser(
            $data->email,
            $hasher->hash($data->password),
            new Name($data->firstName, $data->lastName),
            $parent
        );

        $userRepository->add($user);

        return new JsonResponse($user->toArray(), Response::HTTP_CREATED);
    }
}
