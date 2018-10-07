<?php
/*
Junghoe Hwang	16242934
Robert Harper	96066910
Erdem Alpkaya	16226114

*/
namespace team\a2\controller;
use team\a2\view\View;


/**
 * Class HomeController
 * @package team\a2\controller
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class HomeController extends Controller
{
    /**
     * Action work when user on Home page
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
        $view = new View('main');
        echo $view->render();
        //$this->redirect('accountIndex');
    }
    public function aboutus()
    {
        $view = new View('aboutus');
        echo $view->render();
    }
}
