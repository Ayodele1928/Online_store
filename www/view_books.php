<?php 


session_start();
	$page_title = "View books";

	include 'includes/db.php';

	include 'includes/functions.php';

	include 'includes/headerLinks.php';

	$errors = [];

	
	if (array_key_exists('edit', $_POST)) {
		$clean = array_map('trim', $_POST);
		editBooks($conn, $clean);
	}
	if (isset($_GET['success'])) {
		echo $_GET['success'];
	}


?>
<div class="wrapper">
		<div id="stream">
			<p> 
		<?php

		if (isset($_GET['action'])) {
			if ($_GET['action'] = "edit") {
				
			
		



		?>
		<h3>Edit Product</h3>
			<form id="register" method="POST" action="view_books.php">
				<input type="text" name="title" placeholder="Book title" value="<?php echo $_GET['title'];   ?>" />
				<input type="hidden" name="book_id" value="<?php echo $_GET['book_id'];  ?>">
				<input type="submit" name="edit" value="Edit">
			</form>
			<?php
		}
	}

	if (isset($_GET['act'])) {
		if ($_GET['act'] = "delete") {
			deleteBooks($conn, $_GET['book_id']);

		}
	}

			?>
			</p>
<h3> Books </h3>
<hr>
	<table id="tab">
		<thead>
			<tr>
				
				<th>Title</th>
				<th>Author</th>
				<th>Price</th>
				<th>Year</th>
				<th>ISBN</th>
				<th>Book Cover</th>
				<th>edit</th>
				<th>delete</th>
			</tr>
		</thead>
		<tbody>
			<?php  $view = view_books($conn); echo 
			$view; ?>
		</tbody>
	</table>
		
		</div>

</div>

<?php
	include 'includes/footer.php';

	?>