<?php
/*
Junghoe Hwang	16242934
Robert Harper	96066910
Erdem Alpkaya	16226114

*/
namespace team\a2\controller;
use team\a2\model\{AccountModel, AccountCollectionModel};
use team\a2\view\View;

/**
 * Class AccountController
 *
 * @package team\a2\controller
 * @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class AccountController extends Controller
{
    /**
     * Account Index Action
     *
     * @throws \team\a2\Exceptions\BankExceptions
     */
    public function indexAction()
    {
        session_start();
 
        //Expire the session if user is inactive for 30
        //minutes or more.
        $expireAfter = 5;
        
        //Check to see if our "last action" session
        //variable has been set.
        if(isset($_SESSION['last_action'])){
            
            //Figure out how many seconds have passed
            //since the user was last active.
            $secondsInactive = time() - $_SESSION['last_action'];
            
            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfter * 60;
            
            //Check to see if they have been inactive for too long.
            if($secondsInactive >= $expireAfterSeconds){
                //User has been inactive for too long.
                //Kill their session.
                session_unset();
                session_destroy();
                $this->redirect('Home');
            }
            
        }
        //Assign the current timestamp as the user's
        //latest activity
        $_SESSION['last_action'] = time();
        if($_SESSION['loggedin']){
            $collection = new AccountCollectionModel($_SESSION['cus_id']);
            $accounts = $collection->getAccounts();
            $view = new View('accountIndex');
            $view->addData('count', $collection->getN());
            $view->addData('accounts', $accounts);
            echo $view->render();
        }
        else{
            $this->redirect('Home');
        }

    }

    /**
     * Account create Action
     *
     * @throws \team\a2\Exceptions\BankExceptions
     */
    public function createAction()
    {
        session_start();
        //Expire the session if user is inactive for 30
        //minutes or more.
        $expireAfter = 5;
        
        //Check to see if our "last action" session
        //variable has been set.
        if(isset($_SESSION['last_action'])){
            
            //Figure out how many seconds have passed
            //since the user was last active.
            $secondsInactive = time() - $_SESSION['last_action'];
            
            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfter * 60;
            
            //Check to see if they have been inactive for too long.
            if($secondsInactive >= $expireAfterSeconds){
                //User has been inactive for too long.
                //Kill their session.
                session_unset();
                session_destroy();
                $this->redirect('Home');
            }
            
        }
        //Assign the current timestamp as the user's
        //latest activity
        $_SESSION['last_action'] = time();
        if($_SESSION['loggedin']){
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
        else{
            $this->redirect('Home');
        }
        
    }

    /**
     * Account delete action
     *
     * @param int $id Account id to be deleted
     * @throws \team\a2\Exceptions\BankExceptions
     */
    public function deleteAction($id)
    {
        session_start();
 
        //Expire the session if user is inactive for 30
        //minutes or more.
        $expireAfter = 5;
        
        //Check to see if our "last action" session
        //variable has been set.
        if(isset($_SESSION['last_action'])){
            
            //Figure out how many seconds have passed
            //since the user was last active.
            $secondsInactive = time() - $_SESSION['last_action'];
            
            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfter * 60;
            
            //Check to see if they have been inactive for too long.
            if($secondsInactive >= $expireAfterSeconds){
                //User has been inactive for too long.
                //Kill their session.
                session_unset();
                session_destroy();
                $this->redirect('Home');
            }
            
        }
        //Assign the current timestamp as the user's
        //latest activity
        $_SESSION['last_action'] = time();
        if($_SESSION['loggedin']){
            $account = (new AccountModel())->load($id);
            if($account->getBalance()==0){
                $account->delete();
                $view = new View('accountDeleted');
                $view->addData('deleted', true);
                echo $view->addData('acc_num', $id)->render();
            }else{
                $view = new View('accountDeleted');
                $view->addData('balance', $account->getBalance());
                $view->addData('acc_num', $id);
                $view->addData('deleted', false);
                echo $view->render();
            }
        }else{
            $this->redirect('Home');
        }

    }

    /**
     * Account update action
     *
     * @param int $id Account id to be updated
     * @throws \team\a2\Exceptions\BankExceptions
     */
    public function updateAction($id)
    {
        $account = (new AccountModel())->load($id);
        $account->setName('Joe')->save(); // new name will come from Form data
    }
}
