<?php

namespace agilman\a2\model;

use agilman\a2\Exceptions\BankExceptions;


/**
 * Class TransactionCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class TransactionCollectionModel extends Model
{
    private $trans_ids;

    private $N;

    public function __construct($acc_num)
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `trans_id` FROM `transaction` where acc_number = '$acc_num';")) {
            //throw new Exception("No results of account number");
            throw new BankExceptions("No results of account number");
        }
        $this->trans_ids = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getTransactions()
    {
        foreach ($this->trans_ids as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new TransactionModel())->load($id);
        }
    }
}
