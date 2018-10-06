<?php
namespace agilman\a2\model;

use agilman\a2\Exceptions\BankExceptions;

/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountCollectionModel extends Model
{
    private $accountNums;

    private $N;

    private $cus_id;

    public function __construct($id)
    {
        parent::__construct();
       // if (!$result = $this->db->query("SELECT `acc_number` FROM `account` where acc_cus ='$id'and `disabled` = 0;")) {
        if (!$result = $this->db->query("SELECT `acc_number` FROM `account` where acc_cus ='$id';")) {
            throw new BankExceptions("No result of Account number");
        }
        $this->accountNums = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
        $this->cus_id = $id;
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getAccounts()
    {
        foreach ($this->accountNums as $acc_num) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new AccountModel())->load($acc_num);
        }
    }
    public function getN(){
        return $this->N;
    }
}
