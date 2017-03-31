<?php
	#page title
	$page_title = "Login";

	#include header
	include 'includes/header.php';
	#include db connection
	include 'includes/db.php';
	#include funtions
	include 'includes/functions.php';

		if(array_key_exists('register', $_POST)){
			#error caching
			$errors = [];

			if(empty($_POST['email'])){
				$errors['email'] = "Please enter your email";
			}

			if(empty($_POST['password'])){
				$errors['password'] = "You blind? Enter password joor!!";
			}
			if(empty($errors)){
				#do database stuff

				#eliminate unwanted spaces from values in the $_post array
				$clean = array_map('trim', $_POST);

				adminLogin($conn, $clean);
			}
		}


?>
<link rel="stylesheet" type= "text/css" href="../styles/styles.css">

	<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="login.php" method ="POST">
			<div>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="register" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
	</div>
<?php
	#include footer
	include 'includes/footer.php';
?>