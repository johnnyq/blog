<?php
	
include("config.php");

session_start();

if(isset($_GET['logout'])){

	session_destroy();
	header('Location: login.php');

}

if(isset($_POST['login'])){
  
	$email = mysqli_real_escape_string($db_conn,$_POST['email']);
	$password = md5($_POST['password']);

	$sql = mysqli_query($db_conn,"SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password'");

	if(mysqli_num_rows($sql) == 1){
		$row = mysqli_fetch_array($sql);
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['user_email'] = $row['user_email'];
		  
		header("Location: index.php");

	}else{

		$_SESSION['response'] = "
			<div class='alert alert-danger'>
			    Incorrect username or password.
			    <button class='close' data-dismiss='alert'>
					<span>&times;</span>
				</button>
			</div>
		";

		header("Location: login.php");
	
	}
}

if(isset($_POST['forgot_password'])){
  
	$email = mysqli_real_escape_string($db_conn,$_POST['email']);

	$sql = mysqli_query($db_conn,"SELECT * FROM users WHERE user_email = '$email'");

	if(mysqli_num_rows($sql) == 1){
		$row = mysqli_fetch_array($sql);

		$user_id = $row['user_id'];
		
		function generateRandomString($length = 10) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

		$token = generateRandomString();
		
		$url = "https://" . $_SERVER['HTTP_HOST'] . "/" . basename(__DIR__);

		mysqli_query($db_conn,"UPDATE users SET user_token = '$token' WHERE user_id = $user_id");

		mail("$email","Password Reset Request","$url/reset_password.php?user_id=$user_id&token=$token");
		  
		$_SESSION['response'] = "
			<div class='alert alert-success'>
				We just sent a password reset link to your email!
				<button class='close' data-dismiss='alert'>
					<span>&times;</span>
				</button>
			</div>
		";

		header("Location: forgot_password.php");

	}else{

		$_SESSION['response'] = "
			<div class='alert alert-danger'>
			    Email doesn't exist!
			    <button class='close' data-dismiss='alert'>
					<span>&times;</span>
				</button>
			</div>
		";

		header("Location: forgot_password.php");
	
	}
}

if(isset($_POST['reset_password'])){
  
	$user_id = intval($_POST['user_id']);
	$password = md5($_POST['password']);

	mysqli_query($db_conn,"UPDATE users SET user_password = '$password', user_token = '' WHERE user_id = $user_id");

	$_SESSION['response'] = "
		<div class='alert alert-info'>
		    Password has been reset please login with you new password.
		    <button class='close' data-dismiss='alert'>
				<span>&times;</span>
			</button>
		</div>
	";
		  
	header("Location: login.php");

}

if(isset($_SESSION['user_id'])){

	$session_user_id = $_SESSION['user_id'];

	if(isset($_POST['add_blog'])){
		$title = trim(strip_tags(mysqli_real_escape_string($db_conn,$_POST['title'])));
		$body = trim(mysqli_real_escape_string($db_conn,$_POST['body']));

		mysqli_query($db_conn,"INSERT INTO blog SET blog_title = '$title', blog_body = '$body', blog_created_at = NOW(), user_id = $session_user_id") OR DIE("ERROR!");

		header("Location: blogs.php");

	}

	if(isset($_POST['edit_blog'])){
		$blog_id = intval($_POST['blog_id']);
		$title = trim(strip_tags(mysqli_real_escape_string($db_conn,$_POST['title'])));
		$body = trim(mysqli_real_escape_string($db_conn,$_POST['body']));

		mysqli_query($db_conn,"UPDATE blog SET blog_title = '$title', blog_body = '$body' WHERE blog_id = $blog_id");

		$_SESSION['response'] = "
			<div class='alert alert-info'>
			    Blog updated.
			    <button class='close' data-dismiss='alert'>
					<span>&times;</span>
				</button>
			</div>
		";

		header("Location: edit_blog.php?blog_id=$blog_id");

	}

	if(isset($_GET['delete_blog'])){
		$blog_id = intval($_GET['delete_blog']);

		mysqli_query($db_conn,"DELETE FROM blog WHERE blog_id = $blog_id");

		header("Location: blogs.php");

	}

	if(isset($_POST['add_user'])){
		$email = trim(strip_tags(mysqli_real_escape_string($db_conn,$_POST['email'])));
		$password = md5($_POST['password']);

		mysqli_query($db_conn,"INSERT INTO users SET user_email = '$email', user_password = '$password'");

		$_SESSION['response'] = "
			<div class='alert alert-success'>
			    User added.
			    <button class='close' data-dismiss='alert'>
					<span>&times;</span>
				</button>
			</div>
		";

		header("Location: users.php");

	}

	if(isset($_POST['edit_user'])){
		$user_id = intval($_POST['user_id']);
		$email = trim(strip_tags(mysqli_real_escape_string($db_conn,$_POST['email'])));
		$current_password_hash = $_POST['current_password_hash'];
	    $password = $_POST['password'];
	    if($current_password_hash == $password){
	        $password = $current_password_hash;
	    }else{
	        $password = md5($password);
	    }
		
		mysqli_query($db_conn,"UPDATE users SET user_email = '$email', user_password = '$password' WHERE user_id = $user_id");

		header("Location: edit_user.php?user_id=$user_id");

	}

	if(isset($_GET['delete_user'])){
		$user_id = intval($_GET['delete_user']);

		mysqli_query($db_conn,"DELETE FROM users WHERE user_id = $user_id");

		header("Location: users.php");

	}

}

?>