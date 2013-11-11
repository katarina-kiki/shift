<?php

class User{
    private $id 		= 0;
    private $firstName 	= "";
    private $lastName 	= "";
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    public function __get($name){
        return $this->$name;
    }
    
    public function __construct($ID) { 
        global $database;
        
        $sql = "SELECT * FROM user WHERE ID = ".$ID;
        $database->ExecuteSQL($sql);
        
        if($database->arrayedResult != null){
            $this->id               = $database->arrayedResult["ID"];
            $this->firstName        = $database->arrayedResult["FirstName"];
            $this->lastName         = $database->arrayedResult["LastName"];
        }
    }
    	
    public static function loginCheck($username, $password){
        global $database;
        
        $sql = "SELECT * FROM user
				WHERE Username = '".mysql_real_escape_string($username)."'
                AND Password = '".  md5($password)."'";        
        $database->ExecuteSQL($sql);
        
        return $database->arrayedResult['ID'];
    }
}
?>
