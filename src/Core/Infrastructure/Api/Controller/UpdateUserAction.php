<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Api\Controller;

use App\Core\Domain\ValueObject\Name;
use App\Core\Infrastructure\Api\Request\CreateUserRequest;
use App\Core\Infrastructure\Repository\UserRepository;
use App\Shared\Infrastructure\Api\Controller\AbstractAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/users/{id}', name: 'api.users.put', methods: ['PUT'])]
class UpdateUserAction extends AbstractAction
{
    public function __invoke(
        string $id,
        CreateUserRequest $data,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $application = $this->getMyApplication($request);

        $user = $userRepository->getActive($id, $application);

        $user->update(new Name($data->firstName, $data->lastName));

        $em->flush();

        return new JsonResponse($user->toArray());
    }
}
