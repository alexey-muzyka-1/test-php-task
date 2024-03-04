<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Subscriber;

use Stringable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * according to this class base structure of all errors will be identical to:
 * {
 *     message => '',
 *     errors => [],
 *     uri => ''
 *     help => '',
 * }
 */
class AbstractExceptionSubscriber
{
    protected const DEFAULT_EXCEPTION_MESSAGE = 'Something happen during parsing your request.';
    private const HELP_MESSAGE = 'Please contact our support to detect the issue.';

    protected function replaceResponseWithDefaultMessage(ExceptionEvent $event, int $code, ?ConstraintViolationListInterface $violations = null): void
    {
        $this->replaceResponse($event, self::DEFAULT_EXCEPTION_MESSAGE, $code, $violations);
    }

    protected function replaceResponse(
        ExceptionEvent $event,
        string $message,
        int $code,
        ?ConstraintViolationListInterface $violations = null
    ): void {
        $errors = null !== $violations ? self::errorsArray($violations) : [];

        $event->setResponse(
            new JsonResponse([
                'message' => $message,
                'errors' => $errors,
                'uri' => $event->getRequest()->getUri(),
                'help' => self::HELP_MESSAGE,
            ], $code)
        );
    }

    /**
     * @return array<string, string|Stringable>
     */
    private static function errorsArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
