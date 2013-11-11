<?php
class BookedInAdvance implements IRule{
    /**
    * 
    * Checks if the user booked the leave certain number of days in advance, defined for chosen leave type
    *
    * @param string 	$name  		Rule name
    * @param Leave 		$leave  	Requested Leave
    * @param LeaveType 	$leaveType  Leave type
    * @return boolean
    */
    public function check($name, $leave, $leaveType){
        if($name == "BookedInAdvance"){
			// minimum date the leave should be requested
            $dateInAdvance = mktime(0, 0, 0, date('m'), date('d')+ $leaveType->bookInAdvance, date('Y'));
                       
            if(strtotime($leave->start) < $dateInAdvance){
                return "You have to book leave minimum ".$leaveType->bookInAdvance." days earlier!";
            }else{
                return true;
            }
        }
    }
}
?>
