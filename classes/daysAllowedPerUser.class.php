<?php
include "/../helpers/date_helper.php";

class DaysAllowedPerUser implements IRule{
    /**
    * 
    * Checks if the user is allowed to take a leave depending on a number of days left for that leave type in requested
	* month/year
    *   
	* @param string 	$name  		Rule name
    * @param Leave 		$leave  	Requested Leave
    * @param LeaveType 	$leaveType  Leave type
	* @return boolean
    */ 
    public function check($name, $leave, $leaveType) {        
        if($name == "DaysAllowedPerUser"){            
            if($leaveType->settings->perMonth){
				// type of a leave where the 'number of days allowed' is defined for month
                // not implemented 
                return "Not implemented for a case when leave type is defined per month!";
            }else{
                // type of a leave where the 'number of days allowed' is defined for year
                if(date('Y', strtotime($leave->start)) == date('Y', strtotime($leave->end))){
					// start date and end date in same year				
					
					// number of days the user has already taken for that leave type and the year
                    $usedDays = $leave->getUsedNumberOfDaysForUser(false,date('Y', strtotime($leave->start)));
                    
					// number of days the user requested
                    $numOfDaysRequested = floor((strtotime($leave->end)-strtotime($leave->start))/(60*60*24));
					// number of days the user requested without weekends
                    $numOfDaysRequested -= numOfWeekendDays($leave->start, $numOfDaysRequested);

                    if($leaveType->excludeHolidays){
						// all holidays for given period
                        $holidays = Holiday::getHolidaysForPeriod($leave->start, $leave->end);                
                        if($holidays != null){
                            foreach($holidays AS $holiday){
								// exclude holiday days
                                $count = numOfHolidayDays($leave->start, $leave->end, $holiday);
                                $numOfDaysRequested -= $count;
                            }                    
                        }
                    }
                    
                    if($leaveType->settings->numOfDays >= $numOfDaysRequested + $usedDays){
                        return true;
                    }else{
                        return "You have left only ".($leaveType->settings->numOfDays - $usedDays)." days of ".$leaveType->name." in ".date('Y', strtotime($leave->start))."!";
                    }
                }else{
					// start date and end date in diff years ( 30.12.2013 - 10.01.2014)					
					                   
                    $start1 = $leave->start; // 30.12.2013
                    $end1   = mktime(0,0,0,1,1,date('Y',strtotime($leave->end)));
                    $end1   = date('Y-m-d H:i:s',$end1); // 01.01.2014 
					
					// number of days the user has already taken for that leave type and start year 
                    $usedDaysPeriod1 = $leave->getUsedNumberOfDaysForUser(false,date('Y', strtotime($leave->start)));
                    
                    $numOfDaysRequestedPeriod1 = floor((strtotime($end1) - strtotime($start1))/(60*60*24));
                    $numOfDaysRequestedPeriod1 -= numOfWeekendDays($start1, $numOfDaysRequestedPeriod1); //substract weekends 
                                                           
                    if($leaveType->excludeHolidays){
                        $holidays = Holiday::getHolidaysForPeriod($start1, $end1);                
                        if($holidays != null){
                            foreach($holidays AS $holiday){
                                $count = numOfHolidayDays($start1, $end1, $holiday);
                                $numOfDaysRequestedPeriod1 -= $count;//substract holidays
                            }                    
                        }
                    }
                    
                    if($leaveType->settings->numOfDays < $numOfDaysRequestedPeriod1 + $usedDaysPeriod1){                    
                        return "You have left only ".($leaveType->settings->numOfDays-$usedDaysPeriod1)." days of ".$leaveType->name." in ".date('Y', strtotime($start1))."!";
                    }
                    
                    $start2 		 = mktime(0,0,0,1,1,date('Y',strtotime($leave->end)));//01.01.2014
                    $start2 		 = date('Y-m-d H:i:s',$start2);
                    $end2   		 = $leave->end; // 10.01.2014
                    $usedDaysPeriod2 = $leave->getUsedNumberOfDaysForUser(false,date('Y', strtotime($leave->end)));
                    
                    $numOfDaysRequestedPeriod2 = floor((strtotime($end2)-strtotime($start2))/(60*60*24));
                    $numOfDaysRequestedPeriod2 -= numOfWeekendDays($start2, $numOfDaysRequestedPeriod2); 
                                        
                    if($leaveType->excludeHolidays){
                        $holidays = Holiday::getHolidaysForPeriod($start2, $end2); 
                        
                        if($holidays != null){
                            foreach($holidays AS $holiday){
                                $count = numOfHolidayDays($start2, $end2, $holiday);
                                $numOfDaysRequestedPeriod2 -= $count;//substract holidays
                            }                    
                        }
                    }
                    
                    if($leaveType->settings->numOfDays >= $numOfDaysRequestedPeriod2 + $usedDaysPeriod2){
                        return true;
                    }else{
                        return "You have left only ".($leaveType->settings->numOfDays - $usedDaysPeriod2)." days of ".$leaveType->name." in ".date('Y', strtotime($leave->end))."!";
                    }
                }
            }
        } 
    }
}
?>
