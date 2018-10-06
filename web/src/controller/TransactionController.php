<?php
namespace agilman\a2\controller;
use agilman\a2\model\{AccountModel, TransactionModel,TransactionCollectionModel};
use agilman\a2\view\View;


/**
 * Class HomeController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class TransactionController extends Controller
{
    /**
     * Account Index action
     */


    public function withdraw($acc_num)
    {
        session_start();
 
        //Expire the session if user is inactive for 30
        //minutes or more.
        $expireAfter = 1;
        
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
                    $transaction->setTransType(1);
                    $transaction->setAmount($amount);
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

    public function Signup()
    {
        $username = htmlspecialchars($_POST["username"]);        
        $password = htmlspecialchars($_POST["psw"]);
        $confirmed_pw = htmlspecialchars($_POST["cfmpsw"]);
        $fname = htmlspecialchars($_POST["fname"]);
        $lname = htmlspecialchars($_POST["lname"]);
        $address = htmlspecialchars($_POST["address"]);
        if (strcmp($password, $confirmed_pw)!==0){
            $view = new View('signup');
            $view->addData('error', "Password does not match the confirmed Password.");
            echo $view->render();
        }
        //else if(strcmp($username,'')!==0){
        else if(isset($_POST['username'])){
            $customer = new TransactionModel();
            $customer->setFirstName($fname);
            $customer->setLastName($lname);
            $customer->setAddress($address);
            $customer->setUsername($username);
            $customer->setPassword(md5($password));
            $customer->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
           $customer->save();
           $view = new View('user_created');
           $view->addData('username', $username);
           echo $view->render();
        }
        else{
            $view = new View('signup');
            echo $view->render();
        }
        
    }

    public function logout(){
        session_start();
        session_destroy();
        $view = new View('logout');
        echo $view->render();
    }
    
}
