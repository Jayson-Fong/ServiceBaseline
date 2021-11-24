<?php

namespace Service\Controller;

use Service\Component;
use Service\Response;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Controller extends Component
{

    public function actionIndex(): Response
    {
        return $this->app->response('index');
    }

}