<?php

namespace Panel\Infrastructure\Twig\Extensions;

use Panel\Infrastructure\Symfony\Repository\DocTagRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DocTagExtension extends AbstractExtension
{
    public function __construct(
        private readonly DocTagRepository $docTagRepository,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('doc_tags_all', fn () => $this->docTagRepository->findBy([], ['name' => 'ASC'])),
        ];
    }
}
