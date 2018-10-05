<?php
namespace agilman\a2\model;


/**
 * Class AccountModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class CustomerModel extends Model
{
    /**
     * @var integer Account ID
     */
    private $cus_id;
    /**
     * @var string Account Name
     */
    private $cus_fname;

    private $cus_lname;

    private $cus_address;

    private $cus_username;

    private $cus_password;

    private $cus_dob;

    private $cus_phone;

    private $cus_created_at;

    


    /**
     * @return int Account ID
     */
    public function getId()
    {
        return $this->cus_id;
    }

    public function setId(int $id)
    {
        $this->name = $id;

        return $this;
    }


    /**
     * @return string First Name
     */
    public function getFirstName()
    {
        return $this->cus_fname;
    }

    /**
     * @param string $name Account name
     *
     * @return $this AccountModel
     */
    public function setFirstName(string $fname)
    {
        $this->cus_fname = $fname;

        return $this;
    }


    public function getLastName()
    {

        return $this->cus_lname;
    }

    public function setLastName(string $lname)
    {
        $this->cus_lname = $lname;

        return $this;
    }

    public function getAddress()
    {

        return $this->cus_address;
    }

    public function setAddress(string $address)
    {
        $this->cus_address = $address;

        return $this;
    }

    public function getUserName()
    {

        return $this->cus_username;
    }

    public function setUserName(string $username)
    {
        $this->cus_username = $username;

        return $this;
    }

    public function getPassword()
    {

        return $this->cus_lname;
    }

    public function setPassword(string $password)
    {
        $this->cus_password = $password;

        return $this;
    }


    public function getdob()
    {

        return $this->cus_lname;
    }

    public function setdob(string $dob)
    {
        $this->cus_dob = $dob;

        return $this;
    }

    public function getPhone()
    {

        return $this->cus_lname;
    }

    public function setPhone(string $phone)
    {
        $this->cus_phone = $phone;

        return $this;
    }

    public function getCreatedAt()
    {

        return $this->cus_created_at;
    }

    public function setCreatedAt(string $created_at)
    {
        $this->cus_created_at = $created_at;

        return $this;
    }
    

    /**
     * Loads customer information from the database
     *
     * @param int $id Customer ID
     *
     * @return $this CustomerModel
     */
    public function load($usrnm)
    {
        if (!$result = $this->db->query("SELECT * FROM customer WHERE `username` = $usrnm;")) {
            // throw new ...
        } 
        $result = $result->fetch_assoc();
        $this->cus_id = $result['cus_username'];
        $this->cus_fname = $result['cus_fname'];
        $this->cus_lname = $result['cus_lname'];
        $this->cus_address = $result['cus_address'];
        $this->cus_username = $usrnm;
        $this->cus_password = $result['cus_password'];
        $this->cus_dob = $result['cus_dob'];
        $this->cus_phone = $result['cus_phone'];
        $this->cus_created_at = $result['cus_created_at'];        
        return $this;
    }

    /**
     * Saves account information to the database

     * @return $this AccountModel
     */
    public function save()
    {
        $cus_id = $this->cus_id;
        $cus_fname = $this->cus_fname;
        $cus_lname = $this->cus_lname;
        $cus_address = $this->cus_address;
        $cus_username = $this->cus_username;
        $cus_password = $this->cus_password;
        $cus_dob = $this->cus_dob;
        $cus_phone = $this->cus_phone;
        $cus_created_at = $this->cus_created_at;

        if (!isset($this->id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO customer VALUES (NULL,'$cus_fname','$cus_lname', '$cus_address', '$cus_username', '$cus_password', '$cus_dob', '$cus_phone', '$cus_created_at');")) {
                // throw new ...
            }
            $this->id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE customer SET `name` = '$name' WHERE `id` = $this->id;")) {
                // throw new ...
            }
            
        }

        return $this;
    }

    /**
     * Deletes account from the database

     * @return $this AccountModel
     */
    public function delete()
    {
        if (!$result = $this->db->query("DELETE FROM `account` WHERE `account`.`id` = $this->id;")) {
            //throw new ...
        }

        return $this;
    }

    public function __construct(){
        parent::__construct();
        $this->$tableName = "account";
    }
}
