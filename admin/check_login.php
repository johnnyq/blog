<?php

	session_start();
	
	if(!isset($_SESSION['user_id'])){
	    header("Location: login.php");
	    die;
	}

	$session_user_id = $_SESSION['user_id'];
	$session_user_email = $_SESSION['user_email'];

?>