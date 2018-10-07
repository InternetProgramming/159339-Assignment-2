<?php
namespace team\a2\model;
use team\a2\Exceptions\BankExceptions;

/**
 * Class CustomerModel
 * @package team\a2\model
 *  @author Junghoe Hwang
 * @author Robert Harper
 * @author Erdem Alpkaya
 */
class CustomerModel extends Model
{
    /**
     * @var integer Customer ID
     */
    private $cus_id;
    /**
     * @var string Customer First name
     */
    private $cus_fname;

    /**
     * @var string Customer Last name
     */
    private $cus_lname;

    /**
     * @var string Customer Address
     */
    private $cus_address;

    /**
     * @var string Customer Username
     */
    private $cus_username;

    /**
     * @var string Customer Password
     */
    private $cus_password;

    /**
     * @var string Customer Date of Birth
     */
    private $cus_dob;

    /**
     * @var string Customer Phone Number
     */
    private $cus_phone;

    /**
     * @var string Customer information creation Date and time
     */
    private $cus_created_at;

    


    /**
     * @return int Customer ID
     */
    public function getId()
    {
        return $this->cus_id;
    }

    /**
     * @param  int $id
     *
     * @return $this CustomerModel
     */

    public function setId(int $id)
    {
        $this->name = $id;

        return $this;
    }


    /**
     * @return string First Name
     */
    public function getFirstName()
    {
        return $this->cus_fname;
    }

    /**
     * @param   string $name Account name
     *
     * @return  $this AccountModel
     */
    public function setFirstName(string $fname)
    {
        $this->cus_fname = $fname;

        return $this;
    }


    /**
     * @return string customer Last Name
     */
    public function getLastName()
    {

        return $this->cus_lname;
    }

    /**
     * @param   string $lname customer Last Name
     * @return  $this CustomerModel
     */
    public function setLastName(string $lname)
    {
        $this->cus_lname = $lname;

        return $this;
    }

    /**
     * @return string Customer Address
     */
    public function getAddress()
    {

        return $this->cus_address;
    }


    /**
     * @param   string $address customer Address
     * @return  $this CustomerModel
     */
    public function setAddress(string $address)
    {
        $this->cus_address = $address;

        return $this;
    }

    /**
     * @return string Customer Username
     */
    public function getUserName()
    {

        return $this->cus_username;
    }

    /**
     * @param   string $username customer Username
     * @return  $this CustomerModel
     */
    public function setUserName(string $username)
    {
        $this->cus_username = $username;

        return $this;
    }

    /**
     * @return string customer Password
     */
    public function getPassword()
    {

        return $this->cus_password;
    }

    /**
     * @param   string $password customer Password
     * @return  $this CustomerModel
     */
    public function setPassword(string $password)
    {
        $this->cus_password = $password;

        return $this;
    }

    /**
     * @return  string customer Date of Birth
     */
    public function getdob()
    {

        return $this->cus_lname;
    }

    /**
     * @param   string $dob customer Date of Birth
     * @return  $this CustomerModel
     */
    public function setdob(string $dob)
    {
        $this->cus_dob = $dob;

        return $this;
    }

    /**
     * @return string customer Phone number
     */
    public function getPhone()
    {

        return $this->cus_lname;
    }

    /**
     * @param   string $phone customer phone number
     * @return  $this CustomerModel
     */
    public function setPhone(string $phone)
    {
        $this->cus_phone = $phone;

        return $this;
    }

    /**
     * @return  string User information creation Date and time
     */
    public function getCreatedAt()
    {

        return $this->cus_created_at;
    }

    /**
     * @param   string $created_at User information creation Date and time
     * @return  $this CustomerModel
     */
    public function setCreatedAt(string $created_at)
    {
        $this->cus_created_at = $created_at;

        return $this;
    }


    /**
     *
     * Loads customer information to Database
     *
     * @param   string $usrnm Customer Username
     * @return  $this CustomerModel
     *
     */
    public function load($usrnm)
    {
        if (!$result = $this->db->query("SELECT * FROM customer WHERE `cus_username` = '$usrnm';")) {
            // throw new ...
        } 
        $result = $result->fetch_assoc();
        $this->cus_id = $result['cus_id'];
        $this->cus_fname = $result['cus_fname'];
        $this->cus_lname = $result['cus_lname'];
        $this->cus_address = $result['cus_address'];
        $this->cus_username = $usrnm;
        $this->cus_password = $result['cus_password'];
        $this->cus_dob = $result['cus_dob'];
        $this->cus_phone = $result['cus_phone'];
        $this->cus_created_at = $result['cus_created_at'];        
        return $this;
    }

    /**
     * Saves account information to the database
     * If customer already exist then update customer information.
     *
     * @return $this CustomerModel
     */
    public function save()
    {
        $cus_id = $this->cus_id;
        $cus_fname = $this->cus_fname;
        $cus_lname = $this->cus_lname;
        $cus_address = $this->cus_address;
        $cus_username = $this->cus_username;
        $cus_password = $this->cus_password;
        $cus_dob = $this->cus_dob;
        $cus_phone = $this->cus_phone;
        $cus_created_at = $this->cus_created_at;

        if (!isset($cus_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO customer VALUES (NULL,'$cus_fname','$cus_lname', '$cus_address', '$cus_username', '$cus_password', '$cus_dob', '$cus_phone', '$cus_created_at');")) {
                // throw new ...
            }
            $this->id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE customer SET `cus_fname` = '$cus_fname', `cus_lname` = '$cus_lname', `cus_address` = '$cus_address' WHERE `cus_id` = '$cus_id';")) {
                // throw new ...
            }
            
        }

        return $this;
    }

    /**
     * Deletes account from the database
     *
     * @return $this CustomerModel
     */
    public function delete()
    {
        if (!$result = $this->db->query("DELETE FROM `account` WHERE `account`.`id` = $this->id;")) {
            //throw new ...
        }

        return $this;
    }

}
