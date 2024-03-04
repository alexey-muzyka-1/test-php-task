<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Api\Controller;

use App\Core\Infrastructure\Repository\UserRepository;
use App\Shared\Infrastructure\Api\Controller\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/users/{id}', name: 'api.users.get', methods: ['GET'])]
class GetUserAction extends AbstractAction
{
    public function __invoke(
        string $id,
        Request $request,
        UserRepository $userRepository,
    ): JsonResponse
    {
        $application = $this->getMyApplication($request);

        $user = $userRepository->getActive($id, $application);

        return new JsonResponse($user->toArray());
    }
}
