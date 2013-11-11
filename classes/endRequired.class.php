<?php

class EndRequired implements IRule{

    public function check($name, $leave, $leaveType){
		/**
		* 
		* Checks if the user chose the end date if the end date is required
		*   
		* @param string 	$name  		Rule name
		* @param Leave 		$leave  	Requested Leave
		* @param LeaveType 	$leaveType  Leave type
		* @return boolean
		*/ 
        if($name == "EndRequired"){
            if($leaveType->endRequired){                
                if ($leave->end != '1970-01-01 00:00:00'){
                    return true;
                }
                else{
                    return "You have to choose the end date!";
                }
            }else{
					return "Not implemented for a case when end date is not required!";
			}            
        }
    }
}
?>
