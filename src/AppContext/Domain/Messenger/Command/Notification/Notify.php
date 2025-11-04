<?php

namespace App\Domain\Messenger\Command\Notification;

use Symfony\Component\RemoteEvent\RemoteEvent;

class Notify extends RemoteEvent
{
    /**
     * @param mixed[] $payload
     */
    public function __construct(
        string $id,
        array $payload,
        string $name = 'notify',
    ) {
        parent::__construct(name: $name, id: $id, payload: $payload);
    }
}
