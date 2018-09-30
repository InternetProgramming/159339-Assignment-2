<?php
/*
*
* Junghoe(Peter) Hwang - 16242934
* Erdem Alpkaya        - 16226114
* Robert Harper        - 96066919
*
*/

/**
 * Created by PhpStorm.
 * customTemplateException class file
 *
 * PHP version 7.1
 *
 * @author  Junghoe Hwang <after10y@gmail.com>
 * @author Erdem Alpkaya <erdemalpkaya@gmail.com>
 * @author  Robert Harper   <l.attitude37@gmail.com>
 *
 */

namespace team\a2\exception;

/**
 * Class customTemplateException
 *
 * An exception to be thrown when the template has an error for loading.
 *
 *
 * @package team\a2\exception
 */


class customTemplateException extends \Exception
{

    /**
     * @param string $message the Exception message
     * @param int $code The exception code
     */
    public function customTemplateException($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

}