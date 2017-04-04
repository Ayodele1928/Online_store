
	<?php
	#title 
	$page_title = "Register";

	#include db connection
	include 'includes/db.php';
	
	#include header
	include 'includes/headerLinks.php';

	#include functions page
	include 'includes/functions.php';

	?>
<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
	<div class="wrapper">
		<h6 id="register-label">View books</h6>
		<hr>
		<form id="register"  action ="categories.php" method ="POST">

		
			<hr/>

			
		</form>

			<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>Book ID</th>
						<th>Title</th>
						<th>Author</th>
						<th>Category ID</th>
						<th>Price</th>
						<th>Year of publication</th>
						<th>ISBN</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>

				</thead>



				<tbody>
					<?php $view = view_books($conn);
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