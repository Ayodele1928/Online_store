	<?php 
	#title 
	$page_title = "Add books";


	include 'includes/headerLinks.php';
	include 'includes/functions.php';
	include 'includes/db.php';



	 ?>
	<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
	<div class="wrapper">
		<h1 id="register-label">Add books </h1>
		<hr>
		<form id="register" method ="POST" enctype="multipart/form-data">

			<p>Choose book</p>
			<div>
				<input type="file" name="book">
			</div>
			<div>
				<label>Book Title:</label>
				<input type="text" name="title" placeholder="Enter book's title">
			</div>

			<div>
				<label>Author:</label>
				<input type="text" name="author" placeholder="Enter author's name">
			</div>
			<div>
				<label>Price:</label>
				<input type="text" name="price" placeholder="Enter price of the book">
			</div>
			<div>
				<label>Year of Publication:</label>
				<input type="text" name="year_of_pub" placeholder="Enter year of Publication">
			</div>

			<div>
				<label>ISBN:</label>
				<input type="text" name="isbn" placeholder="Enter ISBN number">
			</div>
			
			<div>
				<label> Select Category</label>

				<select name="category">
				<option> Select Category </option>
				<?php 
					$statement = $conn->prepare("SELECT * FROM category");
					$statement->execute();

				while($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
				<option value="<?php echo $row['category_name'] ?>"> <?php echo $row['category_name'] ?></option>	 
				<?php }?>
				</select><br>

				<input type="submit" name="save" value="upload">
			</div>
</div>
				
						
</form>

<?php
	#include footer
	include 'includes/footer.php';
?>