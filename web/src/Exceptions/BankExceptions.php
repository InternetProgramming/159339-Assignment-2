<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 6/10/18
 * Time: 3:52 PM
 */

namespace agilman\a2\Exceptions;


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