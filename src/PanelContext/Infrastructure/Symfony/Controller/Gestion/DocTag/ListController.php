<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocTag;

use Panel\Infrastructure\Symfony\Repository\DocTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/tags',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET],
)]
class ListController extends AbstractController
{
    public function __construct(
        private readonly DocTagRepository $docTagRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/gestion/doc_tag/list.html.twig',
            parameters: [
                'tags' => $this->docTagRepository->findBy([], ['name' => 'ASC']),
            ],
        );
    }
}
