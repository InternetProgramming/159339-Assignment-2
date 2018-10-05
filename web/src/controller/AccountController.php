<?php
namespace agilman\a2\controller;
use agilman\a2\model\{AccountModel, AccountCollectionModel};
use agilman\a2\view\View;

/**
 * Class AccountController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountController extends Controller
{
    /**
     * Account Index action
     */
    public function indexAction()
    {
        session_start();
        $collection = new AccountCollectionModel($_SESSION['cus_id']);
        $accounts = $collection->getAccounts();
        $view = new View('accountIndex');
        $view->addData('accounts', $accounts);
        echo $view->render();
    }
    /**
     * Account Create action
     */
    public function createAction()
    {
        session_start();
        
        if(!empty($_POST['create'] || !empty($_POST['back'])))
        {
            if(strcmp($_POST['create'], "Yes")===0){
                $account = new AccountModel();
                $account->setCustomerId($_SESSION['cus_id']);
                $account->setBalance(0);
                $account->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                $account->save();
                $view = new View('accountCreated');
                $view->addData("complete", true);
                $view->addData("acc_num", $account->getAccountNum());
                echo $view->render();
            }
            else if(strcmp($_POST['back'], "No")===0){
                $this->redirect('accountIndex');
            }
        }
        else {
            $view = new View('accountCreated');
            echo $view->render();
        }   

        
    }

    /**
     * Account Delete action
     *
     * @param int $id Account id to be deleted
     */
    public function deleteAction($id)
    {
        (new AccountModel())->load($id)->delete();
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
        $account = (new AccountModel())->load($id);
        $account->setName('Joe')->save(); // new name will come from Form data
    }
}
