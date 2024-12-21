<?php

declare(strict_types=1);

namespace App\AppContext\Infrastructure\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'rm-tag', template: 'components/rm-tag.html.twig')]
class RMTagComponent
{
    public string $width = '75px';

    public string $style = '';

    public bool $isFilledBlack = false;

    public bool $isFilledWhite = false;

    public bool $isStrokeBlack = false;

    public bool $isStrokeWhite = false;

    public bool $isFillAnimated = false;

    public bool $isStrokeAnimated = false;

    public bool $hasRedirect = false;

    public function getStyleClasses(): string
    {
        $result = '';

        if (! $this->isFilledBlack && ! $this->isFilledWhite) {
            $result .= ' rm-tag-fill-transparent';
        } else {
            $result .= $this->isFilledBlack ? ' rm-tag-fill-black' : ' rm-tag-fill-white';
        }

        if (! $this->isStrokeBlack && ! $this->isStrokeWhite) {
            $result .= ' rm-tag-stroke-transparent';
        } else {
            $result .= $this->isStrokeBlack ? ' rm-tag-stroke-black' : ' rm-tag-stroke-white';
        }

        if ($this->isFillAnimated) {
            $result .= ' rm-tag-fill-animated';
        }

        if ($this->isStrokeAnimated) {
            $result .= ' rm-tag-stroke-animated';
        }

        return $result;
    }
}
