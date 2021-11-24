<?php

namespace Service;

use Exception;
use Stringable;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Phrase implements Stringable
{

    protected string $phraseKey;
    protected array $placeholders;

    public function __construct( string $phraseKey, array $variables = [])
    {
        $this->phraseKey = $phraseKey;
        $this->placeholders = $variables;
    }

    public function __toString(): string
    {
        try {
            return App::locale()->getText($this->phraseKey, $this->placeholders);
        } catch (Exception)
        {
            return $this->phraseKey;
        }
    }

}