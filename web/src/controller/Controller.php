<?php

namespace team\a2\controller;
/*
Junghoe Hwang	16242934
Robert Harper	96066910
Erdem Alpkaya	16226114

*/

class Controller
{/**
 * Class Controller
 *
 * @param $route
 * @param array $params
 *
 * @package team\a2\controller
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
    public function redirect($route, $params = [])
    {
        // Generate a redirect url for a given named route
        $url = $GLOBALS['router']->generate($route, $params);
        header("Location: $url");
    }
}
