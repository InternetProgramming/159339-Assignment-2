<?php
namespace agilman\a2\model;

use agilman\a2\Exceptions\BankExceptions;


/**
 * Class TransactionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class TransactionModel extends Model{

    private $trans_id;

    private $acc_number;

    private $trans_type;

    private $amount;

    private $balance;

    private $reference;

    private $created_at;

    public function getTransId(){

        return $this->trans_id;

    }

    public function getAccountNum(){

        return $this->acc_number;

    }

    public function getTransType(){

        return $this->trans_type;

    }

    public function getAmount(){

        return $this->amount;

    }

    public function getBalance(){

        return $this->balance;

    }

    public function getReference(){

        return $this->reference;

    }

    public function getCreatedAt(){

        return $this->created_at;

    }


    public function setTransId($trans_id){

        $this->trans_id = $trans_id;

        return $this;

    }

    public function setAccountNum($acc_num){

        $this->acc_number = $acc_num;

        return $this;

    }

    public function setTransType($trans_type){

        $this->trans_type = $trans_type;

        return $this;

    }

    public function setAmount($amount){

        $this->amount = $amount;

        return $this;

    }

    public function setBalance($balance){

        $this->balance = $balance;

        return $this;

    }

    public function setReference($reference){

        $this->reference = $reference;

        return $this;

    }

    public function setCreatedAt($created_at){

        $this->created_at = $created_at;

        return $this;

    }


    /**
     * Loads transaction information from the database
     *
     * @param int $id Transaction ID
     *
     * @return $this TransactionModel
     */
    public function load($trans_id)
    {
        if (!$result = $this->db->query("SELECT * FROM `transaction` WHERE `trans_id` = '$trans_id';")) {
            //throw new Exception("No Result");
            throw new BankExceptions("No Result");
        } 
        $result = $result->fetch_assoc();
        $this->trans_id = $trans_id;
        $this->acc_number = $result['acc_number'];
        $this->trans_type = $result['type'];
        $this->amount = $result['amount'];
        $this->balance = $result['balance'];
        $this->reference = $result['reference'];
        $this->created_at = $result['created_at'];
        return $this;
    }

    /**
     * Saves account information to the database

     * @return $this AccountModel
     */
    public function save()
    {
        $acc_number = $this->acc_number;
        $trans_type = $this->trans_type;
        $amount = $this->amount;
        $balance = $this->balance;
        $reference = $this->reference;
        $created_at = $this->created_at;

        if (!isset($this->trans_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `transaction` VALUES (NULL,'$acc_number','$trans_type', '$amount', '$balance', '$reference', '$created_at');")) {
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

    /*
    * In general, deleting transactions doesn't make sense.
    */
}
