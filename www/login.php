<?php
	#page title
	$page_title = "Login";

	#include header
	include 'includes/header.php';



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