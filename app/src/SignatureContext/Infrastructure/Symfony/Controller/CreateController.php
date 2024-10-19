<?php

namespace App\SignatureContext\Infrastructure\Symfony\Controller;

use App\SignatureContext\Domain\Form\SignatureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(SignatureType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signatureDTO = $form->getData();

            return $this->render('signature/generate.html.twig', [
                'signature' => $signatureDTO,
            ]);
        }

        return $this->render('signature/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
