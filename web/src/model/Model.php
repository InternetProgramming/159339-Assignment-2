<?php
namespace agilman\a2\model;

use mysqli;

/**
 * Class Model
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class Model
{
    protected $db;

    // is this the best place for these constants?
    const DB_HOST = 'mysql';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'a2';

    public function __construct()
    {
        $this->db = new mysqli(
            Model::DB_HOST,
            Model::DB_USER,
            Model::DB_PASS
            //Model::DB_NAME
        );

        if (!$this->db) {
            // can't connect to MYSQL???
            // handle it...
            // e.g. throw new someException($this->db->connect_error, $this->db->connect_errno);
        }

        //----------------------------------------------------------------------------
        // Customer Table
        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . Model::DB_NAME . ";");

        if (!$this->db->select_db(Model::DB_NAME)) {
            // somethings not right.. handle it
            error_log("Mysql database not available!", 0);
        }

        $result = $this->db->query("SHOW TABLES LIKE `customer`;");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE customer (
                    cus_id int(8) unsigned NOT NULL auto_increment,
                    cus_fname varchar(80),
                    cus_lname varchar(80),
                    cus_address varchar(255),
                    cus_username varchar(10),
                    cus_password varchar(255),
                    cus_dob varchar(80),
                    cus_phone varchar(80),
                    cus_created_at varchar(80),
                    primary key (cus_id),
                    UNIQUE(cus_username));"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }
            $this->db->query("alter table customer auto_increment = 1000000;");
            
            // We cannot insert sample data because of encrytion for password
            /*
            if (!$this->db->query(
                "INSERT INTO `customer` VALUES (NULL,'Bob', 'Johnson', '23 Massey Road Auckland', 'bob101', ''), (NULL,'Mary');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
            */

        }
        //----------------------------------------------------------------------------
        // Account Table
        //----------------------------------------------------------------------------

        $result = $this->db->query("SHOW TABLES LIKE `account`;");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "Create table account(
                    acc_number int(8) unsigned NOT NULL auto_increment,
                    acc_cus int(8) unsigned,
                    acc_balance DECIMAL(13,2),
                    created_at varchar(80),
                    PRIMARY KEY (acc_number),
                    FOREIGN KEY fk_cus(acc_cus) REFERENCES customer(cus_id)
                );"
            );

            $this->db->query("alter table account auto_increment = 1000000;");

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }
            
        }
    }
}