<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 27/09/18
 * Time: 2:59 PM
 */

namespace team\a2\controller;

use team\a2\model\{AccountModel, AccountCollectionModel, LoginCollectionModel, LoginModel
};
use team\a2\view\View;
class LoginController extends Controller
{
    /**
     * Account Index action
     */
    public function indexAction()
    {
        $collection = new LoginCollectionModel();
        $accounts = $collection->getAccounts();
        $view = new View('loginIndex');
        echo $view->addData('accounts', $accounts)->render();
    }
    /**
     * Account Create action
     */
    public function createAction()
    {
        $account = new LoginModel();
        $names = ['Bob','Mary','Jon','Peter','Grace'];
        shuffle($names);
        $account->setName($names[0]); // will come from Form data
        $account->save();
        $id = $account->getId();
        $view = new View('loginCreated');
        echo $view->addData('accountId', $id)->render();
    }

    /**
     * Account Delete action
     *
     * @param int $id Account id to be deleted
     */
    public function deleteAction($id)
    {
        (new LoginModel())->load($id)->delete();
        $view = new View('accountDeleted');
        echo $view->addData('accountId', $id)->render();
    }
    /**
     * Account Update action
     *
     * @param int $id Account id to be updated
     */
    public function updateAction($id)
    {
        $account = (new LoginModel())->load($id);
        $account->setName('Joe')->save(); // new name will come from Form data
    }


}