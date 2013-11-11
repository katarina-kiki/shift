<?php
session_start();
require_once 'classes/db.class.php';
require_once 'classes/user.class.php';
require_once 'classes/leave.class.php';
require_once 'classes/leave_type.class.php';
require_once 'classes/leave_type_settings.class.php';
require_once 'classes/leave_type_collection.class.php';
require_once 'classes/holiday.class.php';
require_once 'classes/controllerRules.class.php';

if(!isset($_SESSION['shift_user'])){
   header('Location: index.php');
}else{
   $user = unserialize($_SESSION['shift_user']);
}

if(isset($_POST['submit'])){
    
    $IDLeaveType = (int)$_POST['leaveType'];
    $startDate   = date('Y-m-d H:i:s', strtotime($_POST['start']));
    $endDate     = date('Y-m-d H:i:s', strtotime($_POST['end']));
    $note        = strip_tags($_POST['note']);
    
    if(is_numeric($IDLeaveType) && $IDLeaveType > 0){
        if($startDate != '1970-01-01 00:00:00'){
                $leave              = new Leave();
                $leave->IDUser      = (int)$user->id;
                $leave->IDLeaveType = $IDLeaveType;
                $leave->start       = $startDate;
                $leave->end         = $endDate;
                $leave->note        = $note;  

                $leave_type  = new LeaveType();
                $leave_type->load($IDLeaveType);
                $leave_type->loadSettings(); 
                
                if($leave_type->id > 0){
					/* adding rules that should be checked when submitting request*/
                    $controllerRules = new controllerRules();
                    $controllerRules->addRule("EndRequired");
                    //$controllerRules->addRule("MaximumUsersAllowed");
                    $controllerRules->addRule("BookedInAdvance");
                    $controllerRules->addRule("DaysAllowedPerUser");
                    try{
                        $controllerRules->checkRules($leave, $leave_type);
                        $ID = $leave->insert($leave_type->autoApprove, $leave_type->settings->perMonth);
                        
                        if($ID>0){    
                            $submit_success = true;
                            if($leave_type->autoApprove){
                                $msg = "Your request is successfully submitted and automatically approved.";                                
                            }else{
                                $msg = "Your request is successfully submitted and it's waiting for approval.";
                            }
                        }else{
                            $submit_success = false;
                            $msg = "Error happened! Try again later.";
                        }
                        
                    }catch(Exception $e){
                        $submit_success = false;
                        $msg = $e->getMessage();
                    }
                }else{
                    $submit_success = false;
                    $msg = "Leave type does not exist!";
                }            
            
        }else{
            $submit_success = false;
            $msg = "Choose start date!";
        }   
    }else{
        $submit_success = false;
        $msg = "Invalid leave type!";
    }
}

$ltcollection = new LeaveTypeCollection();
$ltcollection->getAll();

?>
<html>
    <head>
		<title>Leave Request</title>
        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#start").datepicker({                    
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $("#end").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#end").datepicker({                    
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $("#start").datepicker("option", "maxDate", selectedDate);
                    }
                });
            });
       </script>
	   <style>
	   body{
			background: url(images/bg.jpg) #10a5d3;
			
			color: #FFFFFF;
			font-width: bold;
	   }
	   
	   #logout{
			width: 120px;
			color: #FFFFFF;
			text-decoration: none;
			padding: 3px;
	   }
	   
	   #logout:hover{
			width: 120px;
			color: #666;
			text-decoration: underline;
			padding: 3px;
	   }
	   
	   .notice {
			width: 100%;
			background: #fff;
			border-bottom: 4px solid #eaeff3;
			color: #e34848;
			position: fixed;
			top: 0;
			font-size: 14px;
			font-weight: bold;
			height: 45px;
			-moz-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.3);
			-webkit-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.3);
			box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.3);
			text-align: center;
			line-height: 45px;
		}
		
		#formdiv{
			margin: 100px auto; 
			width:300px; 
			background-color: #F0F0F0;
			padding:5px;
			-moz-border-radius: 9px;
			-webkit-border-radius: 9px;
			border-radius: 9px;
			margin: 150px auto 0;
			background: url(images/form-bg.png) top left;
			padding: 8px 0 0 8px;
		}
	   </style>
    </head>
    <body>
	<div class="container">		
        
        <?php if($_POST){?>
		<div class="notice" style="<?php if($submit_success){ echo "color:green;";}else{echo "color:#E30613;";}?>"> 
			<p class="warn"><?php echo $msg;?></p>
		</div>
		<?php } ?>
        <div id="formdiv">   
        <form method="post" action="">
            <table>
                <tr>
                    <td>Leave type:</td>
                    <td>
                        <select name="leaveType" style="width:155px;">
                            <?php foreach($ltcollection->collection AS $type){?>
                            <option value="<?php echo $type->id;?>"><?php echo $type->name;?></option>
                            <?php } ?>
                        </select>                        
                    </td>
                </tr>
                <tr>
                    <td>
                       <label for="from">Start</label> 
                    </td>
                    <td>
                        <input type="text" id="start" name="start" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="to">End</label>
                    </td>
                    <td>
                        <input type="text" id="end" name="end" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Note
                    </td>
                    <td>
                        <textarea name="note" style="resize:vertical; height: 80px;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Submit"/></td>
                </tr>                
            </table>     
          </form>
        </div>
		<center>
			<a href="logout.php" id="logout">Log out</a>
		</center>
		</div>
    </body>
</html>