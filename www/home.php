	<?php
	#title 
	$page_title = "Register";

	#include db connection
	include 'includes/db.php';



	#include functions page
	include 'includes/functions.php';



?>
	<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="home.php" class="selected">Home</a></li>
					<li><a href="categories.php">Categories</a></li>
					<li><a href="#">Products</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>
</section>

	<div class="wrapper">

		
	</div>

<?php
	#include footer
	include 'includes/footer.php';

?>