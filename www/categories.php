	<?php
	#title 
	$page_title = "Register";

	#include db connection
	include 'includes/db.php';


	#include functions page
	include 'includes/functions.php';

	include 'includes/headerLinks.php';



	$errors = [];
	if(array_key_exists('add', $_POST)){
		

		#validate input field.
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
	if(array_key_exists('delete', $_POST)){
			$clean = array_map('trim', $_POST);
			Delete_Category($conn, $clean);
		}

		if(isset($_GET['success'])){
			echo $_GET['success'];
		}
		if (isset($_GET['action'])) {
			if ($_GET['action'] = "delete") {
				Delete_Category($conn, $_GET['category_id']);
				# code...
			}
			# code...
		}
?>
<!DOCTYPE html>
<html>
<body>


<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
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



				<tbody>
					<?php $view = category_table($conn);
					echo $view; ?>
          		</tbody>
			</table>
		</div>

		
	</div>

</body>
</html>
<?php
	#include footer
	include 'includes/footer.php';

?>