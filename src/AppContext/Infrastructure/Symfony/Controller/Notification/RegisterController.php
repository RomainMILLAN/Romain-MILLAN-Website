<?php

namespace App\Infrastructure\Symfony\Controller\Notification;

use App\Domain\Messenger\Command\Notification\RegisterPushNotification;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notification_push/register',
    name: RouteCollection::REGISTER->value,
    methods: [Request::METHOD_POST],
)]
class RegisterController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->commandBus->dispatch(
                new RegisterPushNotification(
                    endpoint: $payload['endpoint'],
                    p256dh: $payload['keys']['p256dh'],
                    auth: $payload['keys']['auth'],
                ),
            );
        } catch (HandlerFailedException $exception) {
            if ($exception->getPrevious() instanceof UniqueConstraintViolationException) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }


        return new Response(status: Response::HTTP_CREATED);
    }
}
