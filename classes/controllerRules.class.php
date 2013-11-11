<?php
require_once "rules.interface.php";

require_once "endRequired.class.php";
require_once "bookedInAdvance.class.php";
require_once "maxUserAllowed.class.php";
require_once "daysAllowedPerUser.class.php";

class controllerRules implements IControllerRules{
    private $rules = array(); // array of rule names that should be checked
    
	
    public function addRule($name){              
        $this->rules[] = $name;
    }
	
	/**
    * 
    * Checks if the requested leave satisfies all conditions defined in rules list
    *   
    * @param Leave 		$leave  	Requested Leave
    * @param LeaveType 	$leaveType  Leave type
    */    
    public function checkRules($leave,$leaveType){
        if(count($this->rules) > 0){
            foreach($this->rules AS $ruleName){
                $rule = new $ruleName();                
                $result = $rule->check($ruleName, $leave, $leaveType);
                
                if($result != 1){
                    throw new Exception($result);
                }
            }
        }
    }
}

?>
