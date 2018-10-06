<?php
namespace agilman\a2\model;

use agilman\a2\Exceptions\BankExceptions;

/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class CustomerCollectionModel extends Model
{
    private $cus_id;

    private $N;

    public function __construct()
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `cus_id` FROM `customer`;")) {
            throw new BankExceptions("Could not Find customer");
        }
        $this->cus_id = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     * @throws BankExceptions
     */
    public function getPassword($usrnm)
    {
        if (!$result = $this->db->query("SELECT cus_password FROM customer where cus_username = '$usrnm';")) {
            // throw new ...
            throw new BankExceptions("Couldn't find user's password");
        }
        
        return $result->fetch_assoc();  
    }

    public function getCustomerId($usrnm)
    {
        if (!$result = $this->db->query("SELECT cus_id FROM customer where cus_username = '$usrnm';")) {
            // throw new ...
            throw new BankExceptions( "Could't find User ID");
            //TODO : Peter can you look here; Exception gives a warning!!
        }

        
        return $result->fetch_assoc();  
    }
}

