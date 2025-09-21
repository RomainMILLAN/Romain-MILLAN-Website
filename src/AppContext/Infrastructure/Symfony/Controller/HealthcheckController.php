<?php

namespace App\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HealthcheckController extends AbstractController
{

    public function __invoke(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }

}
