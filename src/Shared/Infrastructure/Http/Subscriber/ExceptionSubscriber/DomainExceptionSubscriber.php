<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Subscriber\ExceptionSubscriber;

use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\Http\Subscriber\AbstractExceptionSubscriber;
use DomainException;
use InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class DomainExceptionSubscriber extends AbstractExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $throwable = $event->getThrowable();

        switch (true) {
            case $throwable instanceof BadRequestHttpException:
                $this->replaceResponse($event, $throwable->getMessage(), Response::HTTP_BAD_REQUEST);

                break;

            case $throwable instanceof EntityNotFoundException:
                $this->replaceResponse($event, $throwable->getMessage(), Response::HTTP_NOT_FOUND);

                break;

            case $throwable instanceof DomainException:
            case $throwable instanceof InvalidArgumentException:
                $this->replaceResponse($event, $throwable->getMessage(), Response::HTTP_CONFLICT);

                break;
        }
    }
}
