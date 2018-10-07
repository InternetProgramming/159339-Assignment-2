<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 6/10/18
 * Time: 3:52 PM
 */


namespace team\a2\Exceptions;
/**
 * Class CustomerController
 *
 * @package team\a2\controller
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class BankExceptions extends \Exception
{

    private $errorMessage;

    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }


}