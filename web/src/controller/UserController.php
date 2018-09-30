<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 26/09/18
 * Time: 2:25 PM
 */

namespace team\a2\controller;


class UserController extends Controller
{

    /**
     * User register action
     */
    public function creatingAction()
    {
        $view = new View('userCreating');
        echo $view->addData(
            'linkTo',function($route,$params=[]) {
            return $this->linkTo($route,$params);
        }
        )
            ->render();
    }


}