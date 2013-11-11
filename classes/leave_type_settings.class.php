<?php

class LeaveTypeSettings{
    private $id				= 0;
    private $IDLeaveType	= 0;
    private $numOfDays		= 0;
    private $perMonth		= false; // true - per month, false - per year
    
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    public function __get($name){
        return $this->$name;
    }
    
	/**
	* 
	* Sets settings for certain leave type
	*   	
	* @param int $IDLeaveType 
	*/
    public function __construct($IDLeaveType) { 
        global $database;
        
		$IDLeaveType = (int) $IDLeaveType;
        $sql = "SELECT * FROM leavetypesettings WHERE IDLeaveType = ".$IDLeaveType;
        $database->ExecuteSQL($sql);
        
        if($database->affected > 0){
            $this->id          = $database->arrayedResult['ID'];
            $this->IDLeaveType = $database->arrayedResult['IDLeaveType'];
            $this->numOfDays   = $database->arrayedResult['NumOfDays'];
            $this->perMonth    = $database->arrayedResult['PerMonth'];
        }
    }
    
}
?>
