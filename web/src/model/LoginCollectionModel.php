<?php

/*
*
* Junghoe(Peter) Hwang - 16242934
* Erdem Alpkaya        - 16226114
* Robert Harper        - 96066919
*
*/
/**
 * Created by PhpStorm.
 * User: erdemalpkaya
 * Date: 27/09/18
 * Time: 11:32 PM
 */

namespace team\a2\model;


/**
 * Class LoginCollectionModel
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

class LoginCollectionModel extends Model
{
    private $accountIds;

    private $N;

    public function __construct()
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `id` FROM `account`;")) {
            // throw new ...
        }
        $this->accountIds = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getAccounts()
    {
        foreach ($this->accountIds as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new AccountModel())->load($id);
        }
    }
}