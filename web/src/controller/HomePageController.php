<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 27/09/18
 * Time: 5:07 PM
 */

namespace team\a2\controller;


class HomePageController extends Controller
{

    /**
     * Account Index action
     */
    public function indexAction()
    {
        $this->redirect('loginIndex');
    }

}


