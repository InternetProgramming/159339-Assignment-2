<?php
namespace team\a2\model;

use team\a2\Exceptions\BankExceptions;

/**
 * Class TransactionModel
 * @package team\a2\model
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class TransactionModel extends Model{
//TODO: Peter Please check balance information!!
    /**
     * @var int Transaction ID
     */
    private $trans_id;

    /**
     * @var string Account number
     */
    private $acc_number;

    /**
     * @var string Transaction Type
     */
    private $trans_type;
    /**
     * @var string Transaction amount
     */
    private $amount;
    /**
     * @var string Account balance
     */
    private $balance;
    /**
     * @var string
     */
    private $reference;
    /**
     * @var string Transaction creation Date and time
     */
    private $created_at;

    /**
     * @return mixed
     */
    public function getTransId(){

        return $this->trans_id;

    }

    /**
     * @return mixed
     */
    public function getAccountNum(){

        return $this->acc_number;

    }

    /**
     * @return mixed
     */
    public function getTransType(){

        return $this->trans_type;

    }

    /**
     * @return mixed
     */
    public function getAmount(){

        return $this->amount;

    }

    /**
     * @return mixed
     */
    public function getBalance(){

        return $this->balance;

    }

    /**
     * @return mixed
     */
    public function getReference(){

        return $this->reference;

    }

    /**
     * @return mixed
     */
    public function getCreatedAt(){

        return $this->created_at;

    }

    /**
     * @param $trans_id int Transaction ID
     * @return $this TransactionModel
     */
    public function setTransId($trans_id){

        $this->trans_id = $trans_id;

        return $this;

    }

    /**
     * @param $acc_num string Account Number
     * @return $this TransactionModel
     */
    public function setAccountNum($acc_num){

        $this->acc_number = $acc_num;

        return $this;

    }

    /**
     * @param $trans_type string Transactio Type
     * @return $this TransactionModel
     */
    public function setTransType($trans_type){

        $this->trans_type = $trans_type;

        return $this;

    }

    /**
     * @param $amount string Transaction amount
     * @return $this TransactionModel
     */
    public function setAmount($amount){

        $this->amount = $amount;

        return $this;

    }

    /**
     * @param $balance string
     * @return $this TransactionModel
     */
    public function setBalance($balance){

        $this->balance = $balance;

        return $this;

    }

    /**
     * @param $reference
     * @return $this TransactionModel
     */
    public function setReference($reference){

        $this->reference = $reference;

        return $this;

    }

    /**
     * @param $created_at
     * @return $this TransactionModel
     */
    public function setCreatedAt($created_at){

        $this->created_at = $created_at;

        return $this;

    }


    /**
     * Loads transaction information from the database
     *
     * @param $trans_id int Transaction ID
     * @return $this TransactionModel
     * @throws BankExceptions
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
        $this->trans_type = $result['trans_type'];
        $this->amount = $result['amount'];
        $this->balance = $result['balance'];
        $this->reference = $result['reference'];
        $this->created_at = $result['created_at'];
        return $this;
    }

    /**
     * Saves account information to the database
     *
     * @return $this TransactionModel
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
