	<?php 
	session_start();
	#title 
	$page_title = "Add books";


	include 'includes/headerLinks.php';
	include 'includes/functions.php';
	include 'includes/db.php';

			#cache errors
		$errors = [];
		
	if(array_key_exists('save', $_POST)){

		$file = fileUpload();

		if($file[0] == false){
			$errors['file'] = $file[1];
		}
		
	

		#validate title
		if(empty($_POST['title'])){
			$errors['title'] ="Please enter a book title <br/>";
		}
		
		#validate author
		if(empty($_POST['author'])){
			$errors['author'] ="Please enter Author's name <br/>";
		}

		#validate price
		if(empty($_POST['price'])){
			$errors['price'] ="Please enter a price of the book <br/>";
		}

		if(empty($_POST['category'])) {
			$errors['category'] = "Please select a category";
		}

		#validate year of publication
		if(empty($_POST['year_of_pub'])){
			$errors['year_of_pub'] ="Please enter a Publication year of the book <br/>";
		}

		#validate isbn
		if(empty($_POST['isbn'])){
			$errors['isbn'] ="Please enter an ISBN number <br/>";
		}

		#validate category
		if(empty($_POST['category'])){
			$errors['category'] ="Please select a category <br/>";
		}
		
		/*$chk = UploadFile($_FILES, 'pic', 'uploads/');

		if($chk[0]) {
				$destination = $chk[1];
			} else {
				$errors['pic'] = "file upload failed";
			}
*/


		if(empty($errors)){
			#do database stuff

			#eliminate unwanted spaces from values in the $_post array
			$clean = array_map('trim', $_POST);
			addBooks($conn, $clean);
		}
	}

/*			$stmt = $conn->prepare("SELECT category_id FROM category WHERE category_name=:ca");
			$stmt->bindParam(":ca", $clean['category']);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$id = $row['category_id'];


	#insert the data 
	$stamt = $conn->prepare("INSERT INTO books(title, author, category_id, price, year_of_pub, isbn, file_path) VALUES(:ti, :au, :cat, :pr, :y, :is,:fi)");

		#bind params..
		$data = [
			':ti' => $clean['title'],
			':au' => $clean['author'],
			':cat' => $id,
			':pr' => $clean['price'],
			':y' => $clean['year_of_pub'],
			':is' => $clean['isbn'],
			':fi' => $destination
			];

			$stamt->execute($data);

		}
	}


*/

	 ?>
	<div class="wrapper">
		<h1 id="register-label">Add books </h1>
		<hr>
		<form id="register" method ="POST" enctype="multipart/form-data">

			<p>Choose book</p>
			<div>
				<?php if(isset($errors['file'])){
					foreach ($errors['file'] as $error => $err) {
						echo '<span class="err">'. $err. '</span>';
					}
				}
			 ?>
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
				<?php $display = displayErrors($errors, 'category');
				echo $display; ?>
				<label> Select Category</label>

				<select name="category">
				<option> Select Category </option>
				<?php 
					$statement = $conn->prepare("SELECT * FROM category");
					$statement->execute();

				while($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
				<option value="<?php echo $row['category_id'] ?>"> <?php echo $row['category_name'] ?></option>	 
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