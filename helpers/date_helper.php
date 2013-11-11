<?php
/*
 * returns number of weekend days in a period $start - ($start + $numOdDaysRequested)
 */
function numOfWeekendDays($start, $numOfDaysRequested){
    $count = 0;      
    $start_sec = strtotime($start);
	
    for($i = 0; $i < $numOfDaysRequested; $i++){
        $current = mktime(0,0,0, date('m',$start_sec), date('d',$start_sec)+$i,date('Y',$start_sec));
        
        if (date('N', $current) >= 6){
            $count++;
		}
    }
    return $count;
}
/*
 * returns number of $holidays days in a period $start - $end
 */    
function numOfHolidayDays($start, $end, $holidays){
    $count = 0;    
        
    $current     = $holidays['Start'];
    $holiday_end = $holidays['End'];
    
    while(strtotime($current) < strtotime($holiday_end)){
        if(strtotime($current) < strtotime($end)){
            if(strtotime($current) >= strtotime($start) && date('N', strtotime($current)) < 6){
				// if $current holiday day is between $start-$end and not weekend (doesn't count weekend days bc if they exists they are substracted in previous method)
                $count++;
			}
            $current = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($current)));
        }
        else {
			break;
		}
    }
    return $count;
}
?>
