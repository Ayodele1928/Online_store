
	<?php
	#title 
	$page_title = "Register";

	#include db connection
	include 'includes/db.php';
	
	#include header
	include 'includes/header.php';

	#include functions page
	include 'includes/functions.php';

		#cache errors
		$errors = [];
	if(array_key_exists('register', $_POST)){
		#cache errors
		$errors = [];

		#validate first  name
		if(empty($_POST['fname'])){
			$errors['fname'] ="Please enter a first name <br/>";
		}
		
		#validate last name
		if(empty($_POST['lname'])){
			$errors['lname'] ="Please enter a last name <br/>";
		}

		#validate email
		if(empty($_POST['email'])){
			$errors['email'] ="Please enter an email address <br/>";
		}

		if(doesEmailExist($conn, $_POST['email'])){
			$errors['email'] = "Email already exists";
		}

		#validate password
		if(empty($_POST['password'])){
			$errors['password'] ="Please enter a password <br/>";
		}

		#validate  confirmed password

		if($_POST['password'] != $_POST['pword']){
			$errors['pword'] ="Passwords do not match <br/>";
		}

		if(empty($errors)){
			#do database stuff

			#eliminate unwanted spaces from values in the $_post array
			$clean = array_map('trim', $_POST);

			doAdminRegister($conn, $clean);
			#doesEmailExist($dbconn, $email);
/*
			#hash the passwords
			$hash = password_hash($clean['password'], PASSWORD_BCRYPT);

			#insert data
			$stmt= $conn->prepare("INSERT INTO admin(fname, lname, email, hash) VALUES(:fn, :ln, :e, :h)");
			#bind params..
			$data = [
				':fn' => $clean['fname'],
				':ln' => $clean['lname'],
				':e' => $clean['email'],
				':h' => $hash
			];

			$stmt->execute($data);*/
		}
	}


?>
	<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
	<div class="wrapper">
		<h1 id="register-label">Admin Register</h1>
		<hr>
		<form id="register"  action ="register.php" method ="POST">
			<div>
				<?php
					#if(isset($errors['fname'])){ echo '<span class="err">'.$errors['fname']. '</span>';}
				$display = displayErrors($errors, 'fname');
				echo $display; 
				?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php
					#if(isset($errors['lname'])){ echo '<span class="err">'.$errors['lname']. '</span>';}
				$display = displayErrors($errors, 'lname');
				echo $display; 
				?>
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php
					#if(isset($errors['email'])){ echo '<span class="err">'.$errors['email']. '</span>';} 
				$display = displayErrors($errors, 'email');
				echo $display;
				?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php
					#if(isset($errors['password'])){ echo '<span class="err">'.$errors['password']. '</span>';}
				$display = displayErrors($errors, 'password');
				echo $display; 
				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<?php
					#if(isset($errors['pword'])){ echo '<span class="err">'.$errors['pword']. '</span>';}
				$display = displayErrors($errors, 'pword');
				echo $display; 
				?>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
	</div>

	<?php
	#include footer
	include 'includes/footer.php';


	 ?>