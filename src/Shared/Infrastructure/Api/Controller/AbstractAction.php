<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Controller;


use App\Core\Domain\Entity\Application;
use App\Core\Infrastructure\Repository\ApplicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AbstractAction
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository
    ) {

    }

    protected function getMyApplication(Request $request): Application
    {
        $apiKey = $request->headers->get('APP_AUTH');

        if (null === $apiKey) {
            throw new BadRequestHttpException('Api key must be provided');
        }

        $application = $this->applicationRepository->findOneBy(['apiKey' => $apiKey]);

        if (null === $application) {
            throw new BadRequestHttpException('Application not found for provided api key');
        }

        return $application;
    }
}
