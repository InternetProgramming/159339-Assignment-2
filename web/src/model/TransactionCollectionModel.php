<?php

namespace team\a2\model;

use team\a2\Exceptions\BankExceptions;


/**
 * Class TransactionCollectionModel
 * @package team\a2\model
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class TransactionCollectionModel extends Model
{
    private $trans_ids;

    private $N;

    public function __construct($acc_num, $orderby='asc')
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `trans_id` FROM `transaction` where acc_number = '$acc_num' order by created_at $orderby;")) {
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

    public function getN(){
        return $this->N;
    }
}
