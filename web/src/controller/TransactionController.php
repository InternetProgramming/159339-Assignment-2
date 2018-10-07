<?php

/*
Junghoe Hwang	16242934
Robert Harper	96066910
Erdem Alpkaya	16226114

*/
namespace team\a2\controller;
use team\a2\model\{AccountModel, AccountCollectionModel, TransactionModel,TransactionCollectionModel};
use team\a2\view\View;

/**
 * Class TransactionController
 * @package team\a2\controller
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */

class TransactionController extends Controller
{

    /**
     * Transaction index action
     *
     * @param $acc_num
     * @throws \team\a2\Exceptions\BankExceptions
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
            $view = new View('transactionView');
            if(isset($_GET['trans_type'])){
                $view->addData('filter', $_GET['trans_type']);
            }
            if(isset($_POST['orderby'])){
                $collection = new TransactionCollectionModel($acc_num, $_POST['orderby']);
            }
            else{
                $collection = new TransactionCollectionModel($acc_num);
            }
            $transctions = $collection->getTransactions();
            $view->addData('count', $collection->getN());
            $view->addData('transctions', $transctions);
            echo $view->render();
        }
        else{
            $this->redirect('Home');
        }

    }

    /**
     * Transaction withdraw function
     *
     * @param $acc_num
     * @throws \team\a2\Exceptions\BankExceptions
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
                    $amount = floor($amount*100)/100;
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
     * Transaction deposit function
     *
     * @param $acc_num
     * @throws \team\a2\Exceptions\BankExceptions
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
                $view = new View('deposit');
                $view->addData('balance', $account->getBalance());
                echo $view->render();
            }else{
                $amount = htmlspecialchars($_POST["amount"]);
                $amount = floor($amount*100)/100;
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

    /**
     * Transaction transfer function
     *
     * @param $acc_num1
     * @throws \team\a2\Exceptions\BankExceptions
     */
    public function transfer($acc_num1)
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
            $account1 = new AccountModel();
            $account1 = $account1->load($acc_num1);
            if(empty($_POST)){
                $view = new View('transfer');
                $view->addData('balance', $account1->getBalance());
                echo $view->render();
            }else{
                $amount = htmlspecialchars($_POST["amount"]);
                $acc_num2 = htmlspecialchars($_POST["acc_num"]);
                $refer1 = htmlspecialchars($_POST["reference1"]);
                $refer2 = htmlspecialchars($_POST["reference2"]);
                $allAccounts = (new AccountCollectionModel())->getAccountNums();
                if ($amount > $account1->getBalance()){
                    $view = new View('transfer');
                    $view->addData('balance', $account1->getBalance());
                    $view->addData('transfer_error', "Current Balance is less than $". $amount. ".");
                    echo $view->render();
                }
                else{
                    if(in_array($acc_num2, $allAccounts)){
                        // $transaction1 indicate the person's who transfers
                        $amount = floor($amount*100)/100; // remove decimal points below 2.
                        $transaction1 = new TransactionModel();
                        $transaction1->setAccountNum($acc_num1);
                        $transaction1->setTransType("Transfer");
                        $transaction1->setAmount($amount*-1);
                        $transaction1->setBalance($account1->getBalance()-$amount);
                        $transaction1->setReference($refer1);
                        $transaction1->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                        $transaction1->save();
                        $account1->setBalance($transaction1->getBalance());
                        $account1->save();

                        $account2 = new AccountModel();
                        $account2 = $account2->load($acc_num2);

                        $transaction2 = new TransactionModel();
                        $transaction2->setAccountNum($acc_num2);
                        $transaction2->setTransType("Transfer");
                        $transaction2->setAmount($amount);
                        $transaction2->setBalance($account2->getBalance()+$amount);
                        $transaction2->setReference($refer2);
                        $transaction2->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                        $transaction2->save();

                        $account2->setBalance($transaction2->getBalance());
                        $account2->save();

                        $view = new View('transfer');
                        $view->addData('balance', $account1->getBalance());
                        $view->addData('transaction', "$". $amount. " successful sent to account ". $acc_num2 . ".");
                        echo $view->render();
                    } else{
                        $view = new View('transfer');
                        $view->addData('transfer_error', "You've entered in-valid account number or it doesn't exist.");
                        echo $view->render();

                    }

                }

            }

            // not logged in
        }else{
            $this->redirect('Home');
        }
    }
}