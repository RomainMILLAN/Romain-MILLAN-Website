<?php

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/project/{project_name}',
    name: RouteCollection::PROJECT->value,
    methods: [Request::METHOD_GET]
)]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function __invoke(
        string $project_name,
    ): Response {
        $project_title = $this->translator->trans('project.' . $project_name . '.title', [], 'front');

        return $this->render('front/portfolio/project.html.twig', [
            'project_title' => $project_title,
            'project_name' => $project_name,
        ]);
    }
}
