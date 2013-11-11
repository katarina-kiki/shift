<?php
class Holiday {
    private $id                 = 0;
    private $name               = "";
    private $start              = 0;
    private $end                = 0;      
    
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
	* Returns all holidays that overlap with requested period
	*   
	* @param string 	$start  start date
	* @param string		$end  	end date
	* @return array 
	*/ 
    public static function getHolidaysForPeriod($start, $end){
        global $database;
        
        $query = "SELECT * FROM holiday
            WHERE (Start <= '".$start."' AND End >='".$start."')
            OR (Start <= '".$end."' AND End >= '".$end."') 
            OR (Start >= '".$start."' AND Start <= '".$end."') 
            OR (End >= '".$start."' AND End <= '".$end."')";
        $database->ExecuteSQL($query);
		
        if($database->records == 1){
            $h[]=$database->arrayedResult;
		}
        else{
            $h = $database->arrayedResult;
		}
        return $h;        
    }
}

?>
