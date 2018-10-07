<?php
namespace team\a2\model;

use team\a2\Exceptions\BankExceptions;

/**
 * Class AccountCollectionModel
 * @package team\a2\model
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class AccountCollectionModel extends Model
{
    private $accountNums;

    private $N;

    public function __construct($id=null)
    {
        parent::__construct();
        if($id!==null){
            if (!$result = $this->db->query("SELECT `acc_number` FROM `account` where acc_cus = '$id' and `disabled` = 0;")) {
                throw new BankExceptions("No result of Account number");
            }
        } 
        else{
            if (!$result = $this->db->query("SELECT `acc_number` FROM `account` where `disabled` = 0;")) {
                throw new BankExceptions("No result of Account number");
            }
        }
        $this->accountNums = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
        
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     * @throws BankExceptions
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

    public function getAccountNums()
    {
        return $this->accountNums;
    }
}
