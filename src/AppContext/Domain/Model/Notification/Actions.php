<?php

namespace App\Domain\Model\Notification;

enum Actions: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
}
