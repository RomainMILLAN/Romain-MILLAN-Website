<?php

namespace Panel\Infrastructure\Tabler\Subscriber;

use KevinPapst\TablerBundle\Event\MenuEvent;
use KevinPapst\TablerBundle\Model\MenuItemInterface;
use KevinPapst\TablerBundle\Model\MenuItemModel;
use Panel\Infrastructure\Symfony\Controller\RouteCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            MenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    public function onSetupNavbar(MenuEvent $event): void
    {
        $event->addItem(
            new MenuItemModel(
                identifier: 'home',
                label: 'Acceuil',
                route: RouteCollection::DASHBOARD->prefixed(),
                icon: 'fas fa-home',
            )
        );

        $services = new MenuItemModel(
            identifier: 'services',
            label: 'Services',
            icon: 'fa fa-server',
        );
        $services->addChild(
            new MenuItemModel(
                identifier: 'services-prod_01_uptime_kuma',
                label: 'Uptime Kuma',
                route: RouteCollection::PROD_01_UPTIME_KUMA->prefixed(),
            )
        );
        $services->addChild(
            new MenuItemModel(
                identifier: 'services-prod_01_dockge',
                label: 'Dockge',
                route: RouteCollection::PROD_01_DOCKGE->prefixed(),
            )
        );
        $event->addItem($services);


        $event->addItem(
            new MenuItemModel(
                identifier: 'signature',
                label: 'Signature',
                route: \Signature\Infrastructure\Symfony\Controller\RouteCollection::CREATE->prefixed(),
                icon: 'fas fa-signature',
            )
        );

        $this->activateByRoute(
            $event->getRequest()
                ->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param MenuItemModel[]|MenuItemInterface[] $items
     */
    protected function activateByRoute(string $route, array $items): void
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}
