<?php
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 24/09/18
 * Time: 2:23 PM
 */

namespace team\a2\exception;

/**
 * Class MySQLDatabaseQueryException
 * @package team\a2\exception
 */
class MySQLDatabaseQueryException extends \Exception
{
    /**
     * MySQLDatabaseQueryException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "MySQL Database Query error", int $code = 0)
    {
        // Using parent constuct, Exception class.
        parent::__construct($message, $code);
    }

}