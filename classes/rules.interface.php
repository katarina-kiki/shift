<?php

interface IRule{
    public function check($name, $leave, $leaveType);   
}

interface IControllerRules{
	public function addRule($name);
	public function checkRules($leave,$leaveType);   
}


?>
