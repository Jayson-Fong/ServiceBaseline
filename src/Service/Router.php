<?php

namespace Service;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Router extends Component
{

    public function process()
    {
        if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        {
            $end = intval(strpos($_SERVER['QUERY_STRING'], '&'));
            $path = preg_replace('/[^A-Za-z\/]/', '',
                str_replace(' ', '', ucwords(str_replace('-', ' ',
                    trim(strtolower(substr($_SERVER['QUERY_STRING'], 0, $end)))
            ))));

            if (str_contains($path, '/'))
            {
                $routePieces = explode('/', $path);
                return $this->app->route($routePieces[0b0], ucfirst($routePieces[0b1]));
            }
            else
            {
                return $this->app->route($path);
            }
        }
        else
        {
            return $this->app->route();
        }
    }

}