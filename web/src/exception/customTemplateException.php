<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 24/09/18
 * Time: 12:13 AM
 */

namespace team\a2\exception;

/**
 * Class customTemplateException
 *
 *
 * @package team\a2\exception
 *
 * @author  Junghoe Hwang <after10y@gmail.com>
 * @author Erdem Alpkaya <erdemalpkaya@gmail.com>
 * @author  Robert Harper   <l.attitude37@gmail.com>
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