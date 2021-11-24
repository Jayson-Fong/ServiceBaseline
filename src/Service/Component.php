<?php

namespace Service;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
abstract class Component
{

    protected App $app;

    function __construct(App $app)
    {
        $this->app = $app;
    }

}