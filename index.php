<?php
session_start();

if(isset($_SESSION['shift_user'])){
    header('Location: profile.php');
}
require_once 'classes/db.class.php';
require_once 'classes/user.class.php';

if(isset($_POST['logIn'])){
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    
    if($username != "" && $password != ""){
        $ID = User::loginCheck($username, $password);
		
        if(is_numeric($ID)&& $ID>0){
            $user = new User($ID);        
            $_SESSION['shift_user'] = serialize($user);        
            header('Location: profile.php');
        }else{
			$msg = "Whoops! We didn't recognize your username or password. Please try again.";
		}
    }else{
		$msg = "Please enter your username and password.";
	}
}
?>
<html>
    <head>
			<!-- General Metas -->
			<meta charset="utf-8" />			
			<title>Login</title>			
			<!-- Stylesheets -->
			<link rel="stylesheet" href="css/base.css">
			<link rel="stylesheet" href="css/skeleton.css">
			<link rel="stylesheet" href="css/layout.css">
	</head>
    <body>
	<?php if($_POST){?>
		<div class="notice">
			<p class="warn"><?php echo $msg;?></p>
		</div>
	<?php }?>
	<div class="container">		
		<div class="form-bg">
			<form method="post" action="">
				<h2>Login</h2>
				<p><input type="text" name="username" value="<?php if($_POST){ echo $_POST['username'];}else{echo "Username...";}?>"></p>
				<p><input type="password" name="password" value="<?php if($_POST){echo $_POST['password'];}else {echo "Password";}?>"></p>
				
				<button type="submit" name ="logIn"></button>
			<form>
		</div>
	</div><!-- container -->
	<!-- JS  -->
	<script src="script/jquery.js"></script>
	<script>window.jQuery || document.write("<script src='script/jquery-1.5.1.min.js'>\x3C/script>")</script>
	<script src="script/app.js"></script>
        
    </body>
</html>
