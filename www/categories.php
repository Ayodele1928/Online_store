<?php
	
	session_start();
	$page_title = "Categories";

	include 'includes/db.php';

	include 'includes/functions.php';

	include 'includes/headerLinks.php';

	$errors = [];

	if (array_key_exists('enter', $_POST)) {
		$clean = array_map('trim', $_POST);
		Add_Category($conn, $clean);
		}


	

	if (isset($_GET['success'])) {
		echo $_GET['success'];
	}
?>
<div class="wrapper">
		<div id="stream"><br/><br/>
		<p> 
		<?php

	if (isset($_GET['act'])) {
		if ($_GET['act'] = "delete") {
			Delete_Category($conn, $_GET['category_id']);

		}
	}
			?>
		<h3>Add Category</h3>
		<form id="register" method="POST" action="categories.php">
			<input type="text" name="category" placeholder="Enter category name" />
			<input type="submit" name="enter" value="Add">
		</form>
		</p>
	

	<table id="tab">
		<thead>
			<tr>
				<th>Category ID</th>
				<th>Category Name</th>
				<th>delete</th>
			</tr>
		</thead>
		<tbody>
			<?php  $view = category_table($conn); echo $view; ?>
		</tbody>
	</table>
		
		</div>

	</div>
	<?php
	include 'includes/footer.php';

	?>

</body>
</html>