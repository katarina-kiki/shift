<?php
define("MAX_USERS_ALLOWED_AT_THE_SAME_TIME", 3);

class MaximumUsersAllowed implements IRule{
    /**
	* 
	* Checks if the number of users that took Leave in requested period is less then max number of users allowed 
	* to take Leave at the same time
	*   
	* @param string 	$name  		Rule name
	* @param Leave 		$leave  	Requested Leave
	* @param LeaveType 	$leaveType  Leave type
	* @return boolean
	*/ 
    public function check($name, $leave, $leaveType) {
        if($name == "MaximumUsersAllowed"){
            if($leave->getNumberOfLeavesForPeriod()<MAX_USERS_ALLOWED_AT_THE_SAME_TIME){
                return true;
            }else{
                echo "Only ".MAX_USERS_ALLOWED_AT_THE_SAME_TIME." workers are allowed to be absent at the same time.";
            }
        }
    }
}

?>
