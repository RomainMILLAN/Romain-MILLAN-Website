<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Signature;

use Panel\Infrastructure\Symfony\Form\Signature\SignatureForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/signature/',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(SignatureForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signatureDTO = $form->getData();

            return $this->render('panel/gestion/signature/generate.html.twig', [
                'signature' => $signatureDTO,
            ]);
        }

        return $this->render('panel/gestion/signature/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
