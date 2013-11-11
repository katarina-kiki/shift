<?php
session_start();
unset($_SESSION['shift_user']);
header('Location: index.php');
?>
