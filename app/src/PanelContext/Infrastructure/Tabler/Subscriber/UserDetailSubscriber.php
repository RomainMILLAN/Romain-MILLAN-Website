<?php

namespace Panel\Infrastructure\Tabler\Subscriber;

use KevinPapst\TablerBundle\Event\UserDetailsEvent;
use KevinPapst\TablerBundle\Model\UserModel;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;

readonly class UserDetailSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserDetailsEvent::class => ['onShowUser', 100],
        ];
    }

    public function onShowUser(UserDetailsEvent $event): void
    {
        if ($this->security->getUser() === null) {
            return;
        }

        /** @var InMemoryUser $myUser */
        $myUser = $this->security->getUser();

        $user = new UserModel('1', $myUser->getUserIdentifier());
        $user->setTitle('Romain MILLAN');

        $event->setUser($user);
    }
}
