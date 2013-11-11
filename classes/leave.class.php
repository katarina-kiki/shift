<?php
class Leave{
    private $ID         = 0;
    private $IDUser     = 0;
    private $IDLeaveType = 0;
    private $start      = '';
    private $end        = '';
    private $note       = '';
    private $approved   = 0;
    
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
	* Returns number of approved leaves that overlap with requested period
	*   	
	* @return int 
	*/ 	
    public function getNumberOfLeavesForPeriod(){
        global $database;
        
        $query = "SELECT * FROM `leave`
            WHERE (Start <= '".$this->start."' AND End >= '".$this->start."')
            OR (Start <= '".$this->end."' AND End >= '".$this->end."') 
            OR (Start >= '".$this->start."' AND Start <= '".$this->end."') 
            OR (End >= '".$this->start."' AND End <= '".$this->end."') AND Approved = 1";
        $database->ExecuteSQL($query);
        
        return $database->affected;        
    }
    
	/**
	* 
	* Returns number of working days user has already taken for chosen leave type in $monthYear
	*   
	* @param bool 	$forMonth   
	* @param int	$monthYear  Month if $forMonth = true, Year if $forMonth = false
	* @return int 
	*/ 
    public function getUsedNumberOfDaysForUser($forMonth, $monthYear){
        global $database;
        
        if($forMonth){
           $query = "SELECT NumOfWorkingDays FROM userleave WHERE IDUser = ".$this->IDUser." AND IDLeaveType=".$this->IDLeaveType." AND Month = ".$monthYear; 
        }else{
           $query = "SELECT NumOfWorkingDays FROM userleave WHERE IDUser = ".$this->IDUser." AND IDLeaveType=".$this->IDLeaveType." AND Year = ".$monthYear;  
        }
            
        $database->ExecuteSQL($query);
        
        if($database->affected > 0){
            return (int)$database->arrayedResult['NumOfWorkingDays'];
        }else{
            return 0;
        }
    }
    
	/**
	* 
	* Inserts a record in leave table
	*   
	* @param bool $autoApprove  If true leave should be approved on insert
	* @param bool $perMonth  	If 'number of days allowed' is defined per month or per year for chosen leave type
	* @return int 
	*/ 
    public function insert($autoApprove,$perMonth){
        global $database;
        
        $query = "INSERT INTO `leave`
            SET IDUser = ".$this->IDUser.",
                IDLeaveType = ".$this->IDLeaveType.",
                Start = '".mysql_real_escape_string($this->start)."',
                End = '".mysql_real_escape_string($this->end)."',
                Note = '".mysql_real_escape_string($this->note)."'";
        
        if($autoApprove){
            $query.=", Approved = 1 ";
		}
		
        $database->ExecuteSQL($query);
        $LastInsertedID = $database->LastInsertID();
        
        if($LastInsertedID > 0){            
            if($autoApprove){                
                if($this->insertUserLeave($this->start, $this->end, $perMonth)){
                    return $LastInsertedID;
                }
                return 0;
            }
            return $LastInsertedID;
        }else{
            return 0;
        }        
    }
    
    private function insertUserLeave($start,$end,$perMonth){
        global $database;
        
        /*
		* here should be done insert 
		* or update of userleave table (NumOfWorkingDays for leave type and month/year)	
        */
        
        return true;
    }
    
	/**
	* 
	* Used for approving/rejecting user's requests
	*   
	* @param bool 	$approved   start date
	* @param bool	$perMonth  	end date
	* @return int 
	*/ 
    public function updateApproved($approved, $perMonth){
        global $database;
        
        $query = "UPDATE `leave` SET Approved = ".$approved.", New = 0 WHERE ID = ".$this->ID;
        $database->ExecuteSQL($query);
        
        if($approved){
            $this->insertUserLeave ($this->start, $this->end, $perMonth);
		}
    }
       
}
?>