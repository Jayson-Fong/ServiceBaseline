<?php

namespace Service\Util;

use ArrayAccess;
use ArrayObject;
use Service\App;
use Service\Exception\AccessException;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class ReadOnlyArray extends ArrayObject
{

    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset];
    }

    /**
     * @throws AccessException
     */
    public function offsetSet($offset, $value): void
    {
        throw new AccessException(App::phrase('exception.illegal_access.read_only'));
    }

    /**
     * @throws AccessException
     */
    public function offsetUnset($offset): void
    {
        throw new AccessException(App::phrase('exception.illegal_access.read_only'));
    }

}