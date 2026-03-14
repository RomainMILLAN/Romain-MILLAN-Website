<?php

namespace App\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): RedirectResponse
    {
        return $this->redirect('/fr');
    }
}
