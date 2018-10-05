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
        session_start();
        if(!empty($_POST)){
            $username = htmlspecialchars($_POST["username"]);        
            $password = htmlspecialchars($_POST["psw"]); 
            $customers = new CustomerCollectionModel();
            $cus_pwd = $customers->getPassword($username);
            $cus_id = $customers->getCustomerId($username);
            // Verify user password and set $_SESSION
            if ( strcmp( md5($password), $cus_pwd['cus_password'] )===0 ) {
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['cus_id'] = $cus_id['cus_id'];
                $this->redirect('accountIndex');
                //$view = new View('loggedin');
                //$view->addData('username', $username);
                //echo $view->render();

            } else{
                $view = new View('login');
                $view->addData('login_error', "Username or Password is wrong. Try again.");
                echo $view->render();
            }

        }else{
        $view = new View('login');
            echo $view->render();
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
        session_destroy();
        $view = new View('logout');
        echo $view->render();
    }
    
}
