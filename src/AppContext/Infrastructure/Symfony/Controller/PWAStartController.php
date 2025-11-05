<?php

namespace App\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PWAStartController extends AbstractController
{

    public function __invoke(): Response {
        return $this->render('app/start.html.twig');
    }

}
