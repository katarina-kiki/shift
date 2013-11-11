<?php

class LeaveTypeCollection{
    private $collection = array();
    
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    public function __get($name){
        return $this->$name;
    }
    
    public function __construct() { 
    }
    
	/**
	* 
	* Returns all leave types
	*   	
	* @return array 
	*/
    public function getAll(){
        global $database;
        
        $query = "SELECT * FROM leavetype ORDER BY Name DESC";
        $database->ExecuteSQL($query);
        
        $c = array();
        if($database->records > 1){
            foreach($database->arrayedResult AS $lt){
                $leave_type = new LeaveType();

                $leave_type->id               = $lt["ID"];
                $leave_type->name             = $lt["Name"];
                $leave_type->endRequired      = $lt["endRequired"];
                $leave_type->autoApprove      = $lt["autoApprove"];
                $leave_type->excludeHolidays  = $lt["excludeHolidays"];
                $leave_type->bookInAdvance    = $lt["bookInAdvance"];

                $c[] = $leave_type;
            }
        }else{
            $lt = $database->arrayedResult;            
            $leave_type = new LeaveType();

            $leave_type->id               = $lt["ID"];
            $leave_type->name             = $lt["Name"];
            $leave_type->endRequired      = $lt["endRequired"];
            $leave_type->autoApprove      = $lt["autoApprove"];
            $leave_type->excludeHolidays  = $lt["excludeHolidays"];
            $leave_type->bookInAdvance    = $lt["bookInAdvance"];

            $c[] = $leave_type;            
        }        
        $this->collection = $c;
    }
       
}
?>
