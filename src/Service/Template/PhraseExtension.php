<?php

namespace Service\Template;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Service\App;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class PhraseExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('phrase', [$this, 'renderPhrase']),
        ];
    }

    public function renderPhrase(string $phraseKey, array $variables = []): string
    {
        return App::phrase($phraseKey, $variables);
    }

}