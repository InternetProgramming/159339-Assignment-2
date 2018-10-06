<?php
namespace agilman\a2\controller;
use agilman\a2\model\{AccountModel, TransactionModel,TransactionCollectionModel};
use agilman\a2\view\View;


/**
 * Class TransactionController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class TransactionController extends Controller
{

        /**
     * Account Index action
     */
    public function indexAction($acc_num)
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
            $collection = new TransactionCollectionModel($acc_num);
            $transctions = $collection->getTransactions();
            $view = new View('transactionView');
            $view->addData('count', $collection->getN());
            $view->addData('transctions', $transctions);
            echo $view->render();
        }
        else{
            $this->redirect('Home');
        }

    }
    /**
     * Transaction Withdraw Action
     */


    public function withdraw($acc_num)
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

        // check logged in or not
        if($_SESSION['loggedin']){
            $account = new AccountModel();
            $account = $account->load($acc_num);
            if(empty($_POST)){
                $view = new View('withdraw');
                $view->addData('balance', $account->getBalance());
                 echo $view->render();
            }else{
                $amount = htmlspecialchars($_POST["amount"]);
                if ($amount > $account->getBalance()){
                    $view = new View('withdraw');
                    $view->addData('balance', $account->getBalance());
                    $view->addData('withdraw_error', "Current Balance is less than $". $amount. ".");
                    echo $view->render();

                } else{
                    $transaction = new TransactionModel();
                    $transaction->setAccountNum($acc_num);
                    $transaction->setTransType("Withdraw");
                    $transaction->setAmount($amount*-1);
                    $transaction->setBalance($account->getBalance()-$amount);
                    $transaction->setReference("");
                    $transaction->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                    $transaction->save();
                    $account->setBalance($transaction->getBalance());
                    $account->save();
                    $view = new View('withdraw');
                    $view->addData('balance', $account->getBalance());
                    $view->addData('transaction', "$". $amount. " Successfully Withdrawn");
                    echo $view->render();
                }
            }
        // not logged in
        }else{
            $this->redirect('Home');
        }
    }

    /**
     * Transaction deposit Action
     */


    public function deposit($acc_num)
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

        // check logged in or not
        if($_SESSION['loggedin']){
            $account = new AccountModel();
            $account = $account->load($acc_num);
            if(empty($_POST)){
                $view = new View('withdraw');
                $view->addData('balance', $account->getBalance());
                 echo $view->render();
            }else{
                $amount = htmlspecialchars($_POST["amount"]);
                $transaction = new TransactionModel();
                $transaction->setAccountNum($acc_num);
                $transaction->setTransType("Deposit");
                $transaction->setAmount($amount);
                $transaction->setBalance($account->getBalance()+$amount);
                $transaction->setReference("");
                $transaction->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                $transaction->save();
                $account->setBalance($transaction->getBalance());
                $account->save();
                $view = new View('withdraw');
                $view->addData('balance', $account->getBalance());
                $view->addData('transaction', "$". $amount. " Successfully Deposited");
                echo $view->render();
            }
            
        // not logged in
        }else{
            $this->redirect('Home');
        }
    }



    public function transfer($acc_num)
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

        // check logged in or not
        if($_SESSION['loggedin']){
            $account = new AccountModel();
            $account = $account->load($acc_num);
            if(empty($_POST)){
                $view = new View('withdraw');
                $view->addData('balance', $account->getBalance());
                 echo $view->render();
            }else{
                $amount = htmlspecialchars($_POST["amount"]);
                $transaction = new TransactionModel();
                $transaction->setAccountNum($acc_num);
                $transaction->setTransType("Deposit");
                $transaction->setAmount($amount);
                $transaction->setBalance($account->getBalance()+$amount);
                $transaction->setReference("");
                $transaction->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                $transaction->save();
                $account->setBalance($transaction->getBalance());
                $account->save();
                $view = new View('withdraw');
                $view->addData('balance', $account->getBalance());
                $view->addData('transaction', "$". $amount. " Successfully Deposited");
                echo $view->render();
            }
            
        // not logged in
        }else{
            $this->redirect('Home');
        }
    }


    
}
