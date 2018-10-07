<?php
namespace team\a2\model;

use team\a2\Exceptions\BankExceptions;

/**
 * Class CustomerCollectionModel
 * @package team\a2\model
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
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
     * @param $usrnm customer username
     * @return array
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

    /**
     *
     *
     * @param $usrnm
     * @return array
     * @throws BankExceptions
     */
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

