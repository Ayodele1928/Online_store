	<?php 
	#title 
	$page_title = "Add books";


	include 'includes/headerLinks.php';
	include 'includes/functions.php';
	include 'includes/db.php';

			#cache errors
		$errors = [];
		
	if(array_key_exists('save', $_POST)){
		
		if(empty($_POST['book'])){
			$errors['book'] ="Please select a book <br/>";
		}

		#validate first  name
		if(empty($_POST['title'])){
			$errors['title'] ="Please enter a book title <br/>";
		}
		
		#validate last name
		if(empty($_POST['author'])){
			$errors['author'] ="Please enter Author's name <br/>";
		}

		#validate email
		if(empty($_POST['price'])){
			$errors['price'] ="Please enter a price of the book <br/>";
		}


		if(empty($_POST['year_of_pub'])){
			$errors['year_of_pub'] ="Please enter a Publication year of the book <br/>";
		}

		if(empty($_POST['isbn'])){
			$errors['isbn'] ="Please enter an ISBN number <br/>";
		}

	
	
		if(empty($errors)){
			#do database stuff

			#eliminate unwanted spaces from values in the $_post array
			$clean = array_map('trim', $_POST);

		}
	}




	 ?>
	<link rel="stylesheet" type= "text/css" href="../styles/styles.css">
	<div class="wrapper">
		<h1 id="register-label">Add books </h1>
		<hr>
		<form id="register" method ="POST" enctype="multipart/form-data">

			<p>Choose book</p>
			<div>
				<?php $display = displayErrors($errors, 'book');
				echo $display; ?>
				<input type="file" name="book">
			</div>
			<div>
				<?php $display = displayErrors($errors, 'title');
				echo $display; ?>
				<label>Book Title:</label>
				<input type="text" name="title" placeholder="Enter book's title">
			</div>

			<div>
				<label>Author:</label>
				<input type="text" name="author" placeholder="Enter author's name">
				<?php $display = displayErrors($errors, 'author');
				echo $display; ?>
			</div>

			<div>
				<?php $display = displayErrors($errors, 'price');
				echo $display; ?>
				<label>Price:</label>
				<input type="text" name="price" placeholder="Enter price of the book">

			</div>

			<div>
				<?php $display = displayErrors($errors, 'year_of_pub');
				echo $display; ?>
				<label>Year of Publication:</label>
				<input type="text" name="year_of_pub" placeholder="Enter year of Publication">
			</div>

			<div>
				<?php $display = displayErrors($errors, 'isbn');
				echo $display; ?>
				<label>ISBN:</label>
				<input type="text" name="isbn" placeholder="Enter ISBN number">

			</div>
			
			<div>
				<label> Select Category</label>

				<select name="select_cat">
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