<?php
/*
*
* Junghoe(Peter) Hwang - 16242934
* Erdem Alpkaya        - 16226114
* Robert Harper        - 96066919
*
*/
namespace team\a2\model;

use mysqli;
use team\a2\exception\MySQLDatabaseQueryException;

/**
 * Class Model
 *
 * @package team/a2
 *
 * Code foundation by:
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 *
 *
 * @author  Junghoe Hwang <after10y@gmail.com>
 * @author Erdem Alpkaya <erdemalpkaya@gmail.com>
 * @author  Robert Harper   <l.attitude37@gmail.com>
 */
class Model
{
    protected $db;

    // is this the best place for these constants?
    const DB_HOST = 'mysql';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'team_a2';

    /**
     * Model constructor.
     * @throws MySQLDatabaseQueryException
     */
    public function __construct()
    {
        $this->db = new mysqli(
            Model::DB_HOST,
            Model::DB_USER,
            Model::DB_PASS,
            Model::DB_NAME
        );

        if (!$this->db) {
            // can't connect to MYSQL???
            // handle it...
            // e.g. throw new someException($this->db->connect_error, $this->db->connect_errno);
            throw new MySQLDatabaseQueryException($this->db->connect_error,$this->db->connect_errno);
        }

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . Model::DB_NAME . ";");

        if (!$this->db->select_db(Model::DB_NAME)) {
            // somethings not right.. handle it
            throw new MySQLDatabaseQueryException("Failed Query for Database");
            error_log("Mysql database not available!", 0);
        }

        $result = $this->db->query("SHOW TABLES LIKE 'account';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `account` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(256) DEFAULT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                throw new MySQLDatabaseQueryException("Failed creating the Table");
                error_log("Failed creating table account", 0);
            }


            if (!$this->db->query(
                "INSERT INTO `account` VALUES (NULL,'Bob'), (NULL,'Mary');"
                )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
                }

        }

    /*//------------    // Trial table ------------------------
        $result = $this->db->query("SHOW TABLES LIKE 'trans';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `Transaction` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(256) DEFAULT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                throw new MySQLDatabaseQueryException("Failed creating the Table");
                error_log("Failed creating table account", 0);
            }


            if (!$this->db->query(
                "INSERT INTO `Transaction` VALUES (NULL,'Bob'), (NULL,'Mary');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }

        }

        //Trial USer ---------

        $result = $this->db->query("SHOW TABLES LIKE 'User';");

        if($result->num_rows == 0) {
            //table doesn't exist
            //create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `User` (
                              `Username` VARCHAR (20) NOT NULL,
                              `Password` VARCHAR (20) NOT NULL,
                              `UserID` INT NOT NULL AUTO_INCREMENT,
                              UNIQUE (`Username`),
                              PRIMARY KEY (`UserID`)
                               );"
            );

            if(!$result) {
                throw new MySQLDatabaseQueryException("Failed creating table User");
                error_log("Failed creating table User",0);


                if (!$this->db->query(
                    "INSERT INTO `User` VALUES (NULL,'Bob'), (NULL,'Mary');"
                )) {
                    // handle appropriately
                    error_log("Failed creating sample data!", 0);
                }}
        }

*/



        //----------------------------------------------------------------------------
    }
}
