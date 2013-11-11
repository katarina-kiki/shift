<?php
class LeaveType{
    private $id                 = 0;
    private $name               = "";
    private $endRequired        = 0;
    private $autoApprove        = 0;
    private $bookInAdvance      = 0;
    private $excludeHolidays    = 0;
    
    private $settings           = array();
    
    
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
	* Loads information for certain leave type 
	*   
	* @param int 	$ID 	
	*/ 
    public function load($ID){
        global $database;
        
        $ID = (int) $ID;
        
        $sql = "SELECT * FROM leavetype WHERE ID = ".$ID;
        $database->ExecuteSQL($sql);
        
        if($database->arrayedResult != null){
            $this->id               = $database->arrayedResult["ID"];
            $this->name             = $database->arrayedResult["Name"];
            $this->endRequired      = $database->arrayedResult["endRequired"];
            $this->autoApprove      = $database->arrayedResult["autoApprove"];
            $this->excludeHolidays  = $database->arrayedResult["excludeHolidays"];
            $this->bookInAdvance    = $database->arrayedResult["bookInAdvance"];
        }
    }
    
	/**
	* 
	* Loads settings for certain leave type 
	*  	
	*/
    public function loadSettings(){       
       $this->settings = new LeaveTypeSettings($this->id);        
    }
       
}
?>
