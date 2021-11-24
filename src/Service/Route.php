<?php

namespace Service;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Route extends Component
{

    protected string $controllerRaw;
    protected string $actionRaw;

    public function __construct(App $app, string $controller, string $action)
    {
        parent::__construct($app);
        $this->controllerRaw = $controller;
        $this->actionRaw = $action;
    }

    public function go(): Response
    {
        $controller = $this->app->controller($this->controllerRaw);
        $method = 'action' . $this->actionRaw;
        if (method_exists($controller, 'action' . $this->actionRaw))
        {
            return $controller->$method();
        }
        else
        {
            return $controller->actionIndex();
        }
    }

}