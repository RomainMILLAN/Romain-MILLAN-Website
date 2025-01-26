<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/c-uptime-robot',
    name: RouteCollection::CLOUD_UPTIME_ROBOT->value,
    methods: [Request::METHOD_GET],
)]
class CUptimeRobotController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/cloud_uptime_robot.html.twig',
        );
    }
}
