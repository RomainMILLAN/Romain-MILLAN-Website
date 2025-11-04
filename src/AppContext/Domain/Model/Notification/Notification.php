<?php

namespace App\Domain\Model\Notification;

class Notification
{
    /**
     * @param Action[] $actions
     */
    public function __construct(
        public string $body,
        private string $title = 'RomainMILLAN/Panel',
        private array $actions = [],
    ) {
    }

    /**
     * @return array<mixed,mixed>
     */
    public function toArray(): array
    {
        $actions = [];
        foreach ($this->actions as $action) {
            $actions[] = $action->toArray();
        }

        return [
            'title' => $this->title,
            'options' => [
                'body' => $this->body,
                'actions' => $actions,
            ],
        ];
    }
}
