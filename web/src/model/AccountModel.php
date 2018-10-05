<?php
namespace agilman\a2\model;


/**
 * Class AccountModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountModel extends Model
{
    /**
     * @var integer Account Number
     */
    private $acc_number;
    /**
     * @var string Customer Id
     */
    private $acc_cus;

    private $balance;

    private $created_at;


    /**
     * @return string Account Number
     */
    public function getAccountNum()
    {
        return $this->acc_number;
    }

    /**
     * @return string Customer ID
     */
    public function getCustomerId()
    {
        return $this->acc_cus;
    }

    /**
     * @return float balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return string Customer ID
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $name Account name
     *
     * @return $this AccountModel
     */
    public function setAccNumber($accNumber)
    {
        $this->acc_number = $accNumber;

        return $this;
    }

    public function setCustomerId($cust_id)
    {
        $this->acc_cus = $cust_id;

        return $this;
    }

    public function setBalance($bal)
    {
        $this->balance = $bal;

        return $this;
    }

    public function setCreatedAt($time)
    {
        $this->created_at = $time;

        return $this;
    }

    

    /**
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
     */
    public function load($acc_num)
    {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `acc_number` = '$acc_num';")) {
            throw new Exception("No Result");
        } 
        $result = $result->fetch_assoc();
        $this->acc_number = $result['acc_number'];
        $this->acc_cus = $result['acc_cus'];
        $this->balance = $result['acc_balance'];
        $this->created_at = $result['created_at'];
        return $this;
    }

    /**
     * Saves account information to the database

     * @return $this AccountModel
     */
    public function save()
    {
        session_start();
        $acc_cus = $this->acc_cus;
        $balance = $this->balance;
        $created_at = $this->created_at;
        if (!isset($this->acc_number)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$acc_cus','$balance', '$created_at');")) {
                // throw new ...
            }
            $this->acc_number = $this->db->insert_id;
        } 
        /* We may not need to update account information in general.
        else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE $table SET `name` = '$name' WHERE `id` = $this->id;")) {
                // throw new ...
            } 
        }
         */

        return $this;
    }

    /**
     * Deletes account from the database

     * @return $this AccountModel
     */
    public function delete()
    {
        if (!$result = $this->db->query("DELETE FROM `account` WHERE `account_number` = $this->$acc_number;")) {
            //throw new ...
        }

        return $this;
    }
}
