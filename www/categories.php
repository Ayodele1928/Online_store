	<?php
	#title 
	$page_title = "Register";

	#include db connection
	include 'includes/db.php';


	#include functions page
	include 'includes/functions.php';


	$errors = [];
	if(array_key_exists('add', $_POST)){
		

		#validate first  name
		if(empty($_POST['category'])){
			$errors['category'] ="Please enter a Category <br/>";
		}

		if(empty($errors)){
			#do database stuff

			#eliminate unwanted spaces from values in the $_post array
			$clean = array_map('trim', $_POST);

			Add_Category($conn, $clean);


		}
	}
?>
	<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="home.php" >Home</a></li>
					<li><a href="categories.php" class="selected">Categories</a></li>
					<li><a href="#">Products</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>
</section>

	<div class="wrapper">
		<h6 id="register-label">Add Categories</h6>
		<hr>
		<form id="register"  action ="categories.php" method ="POST">

			<div>
				<label>Category:</label>	
				<?php
					#if(isset($errors['category'])){ echo '<span class="err">'.$errors['category']. '</span>';}
				$display = displayErrors($errors, 'category');
				echo $display;

				?>
		
				<input type="text" name="category" placeholder=""><br />
				<input type="submit" name="add" value="add">
			</div>
			<hr/>

			
		</form>

			<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>Category</th>
						<th>Category_ID</th>
						<th>Remove</th>
					</tr>
				</thead>
<?php 


 ?>
				<tbody>
					<?php $view = category_table($conn);
					echo $view; ?>
          		</tbody>
			</table>
		</div>


		
	</div>

<?php
	#include footer
	include 'includes/footer.php';

?>