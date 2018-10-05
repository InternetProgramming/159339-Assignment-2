<?php
namespace agilman\a2\model;

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
            // throw new ...
        }
        $this->cus_id = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getPassword($usrnm)
    {
        if (!$result = $this->db->query("SELECT cus_password FROM customer where cus_username = '$usrnm';")) {
            // throw new ...
            throw new Exception("Couldn't find user's password");
        }
        
        return $result->fetch_assoc();  
    }

    public function getCustomerId($usrnm)
    {
        if (!$result = $this->db->query("SELECT cus_id FROM customer where cus_username = '$usrnm';")) {
            // throw new ...
            throw new Exception("Couldn't find user's id");
        }
        
        return $result->fetch_assoc();  
    }
}

