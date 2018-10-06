<?php
namespace agilman\a2\controller;
use agilman\a2\model\{CustomerModel,CustomerCollectionModel};
use agilman\a2\view\View;


/**
 * Class HomeController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class CustomerController extends Controller
{
    /**
     * Account Index action
     */


    public function Login()
    {
        //Start our session.
        session_start();
        if(!$_SESSION['loggedin']){
            if(!empty($_POST)){
                $username = htmlspecialchars($_POST["username"]);
                $password = htmlspecialchars($_POST["psw"]); 
                $customer =(new CustomerModel())->load($username);

                // Verify user password and set $_SESSION
                if ( strcmp( md5($password), $customer->getPassword() )===0 ) {
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['cus_id'] = $customer->getId();
                    $_SESSION['last_action'] = time();
                    $this->redirect('accountIndex');

                } else{
                    $view = new View('login');
                    $view->addData('login_error', "Username or Password is wrong. Try again.");
                    echo $view->render();
                }

            }else{
            $view = new View('login');
                echo $view->render();
            }
        }else{
            $this->redirect('accountIndex');
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
            $customer = new CustomerModel();
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
        session_unset();
        session_destroy();
        $view = new View('logout');
        echo $view->render();
    }

    public function edit(){
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
            $customer =(new CustomerModel())->load($_SESSION['username']);
            
            if(isset($_POST['psw'])){
                if ( strcmp( md5($_POST['psw']), $customer->getPassword() )===0 ) {
                    $customer->setFirstName($_POST['fname']);
                    $customer->setLastName($_POST['lname']);
                    $customer->setAddress($_POST['address']);
                    $customer->save();
                    $view = new View('user_created');
                    $view->addData('editted', true);
                    $view->addData('username', $username);
                    echo $view->render();


                } else{
                    $view = new View('user_edit');
                    $view->addData('cus_fname', $customer->getFirstName());
                    $view->addData('cus_lname', $customer->getLastName());
                    $view->addData('cus_address', $customer->getAddress());
                    $view->addData('error', "Typed incorrect Password. Try again.");
                    echo $view->render();
                }


            }else{
                $view = new View('user_edit');
                $view->addData('cus_fname', $customer->getFirstName());
                $view->addData('cus_lname', $customer->getLastName());
                $view->addData('cus_address', $customer->getAddress());
                echo $view->render();
            }
            $password = htmlspecialchars($_POST["psw"]);
            $fname = htmlspecialchars($_POST["fname"]);
            $lname = htmlspecialchars($_POST["lname"]);
            $address = htmlspecialchars($_POST["address"]);

        }else{
            $this->redirect('Home');
        }

    }
    
}
