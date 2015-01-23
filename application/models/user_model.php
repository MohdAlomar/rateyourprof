<?php

class User_model extends MY_Model {
    
    const DB_TABLE = 'users';
    const DB_TABLE_PK = 'user_id';
    
    /**
     * User unique identifier.
     * @var int
     */
    public $user_id;
    
    /**
     *  username.
     * @var string
     */
    public $username;
    
    /**
     *  User eamil.
     * @var string
     */
    public $email;
    
    /**
     *  User password.
     * @var encrypted string
     */
    public $password;
   
    /**
     *  User name ex: Mohd Alomar.
     * @var  string
     */
    public $name;
    
    /**
     *  Role unique identifier.
     * @var int
     */
    public $role_id;
    
    /**
     *  The status of the account .
     * @var boolean
     */
    public $active;
    
     function validate($username1, $password1)
     {

  	if($username1 == $this->username && $password1 == $this->password)
     	{
    		return true;
    	}
    	else return false;
   }
 
}