<?php 
	function doAdminRegister($dbconn, $input){
		#hash the password
		$hash = password_hash($input['password'], PASSWORD_BCRYPT);

		#insert the data 
		$stmt = $dbconn->prepare("INSERT INTO admin(fname, lname, email, hash) VALUES(:fn, :ln, :e, :h)");

		#bind params..
		$data = [
			':fn' => $input['fname'],
			':ln' => $input['lname'],
			':e' => $input['email'],
			':h' => $hash
			];

			$stmt->execute($data);
				

	}

	function doesEmailExist($dbconn, $email){
		$result = false;
		
		$stmt = $dbconn->prepare("SELECT email FROM admin WHERE email=:e");

		#bind params
		$stmt->bindParam(":e", $email);
		$stmt->execute();

		#get number of rows returned
		$count = $stmt->rowCount();

		if($count > 0){
			$result = true;
		}

		return $result;
	}

	function displayErrors($dum, $what){
		$result = "";
		if(isset($dum[$what])){
			$result = '<span class="err">'. $dum[$what]. '</span>';
		}
		return $result;
	}
 	
function adminLogin($dbconn, $enter) {
					$result =[];

			//$hash = password_hash($enter['password'], PASSWORD_BCRYPT);

			
			# prepared statement
			$statement = $dbconn->prepare("SELECT * FROM admin WHERE email=:em");
			
			# bind params
			$statement->bindParam(":em", $enter['email']);
			$statement->execute();

			$row = $statement->fetch(PDO::FETCH_ASSOC);
			
			$count = $statement->rowCount();
			
			if($count !==1 || !password_verify($enter['password'], $row['hash'])){
				$result[] = false;
			}else{
				$result[] = true;
				$result[] = $row;
			}

				return $result;
			
		}
	function redirect($loca){
		header("Location: ".$loca);
	}


function Add_Category($dbconn, $input){
	
		#insert the data 
		$stmt = $dbconn->prepare("INSERT INTO category (category_name) VALUES(:ct)");

		#bind params..
		$data = [
			':ct' => $input['category'],
			];

			if($stmt->execute($data)){
				$success = "<strong>Category sucessfully added</strong>";
				header("Location:categories.php?success=$success");
			}
}

function Delete_Category($dbconn, $input){
			#insert the data 
		$stmt = $dbconn->prepare("DELETE FROM category WHERE category_id = :id");

		#bind params..
		$stmt->bindParam(":id", $input);
		$stmt->execute();
		$success = "<strong>Category deleted</strong>";
		header("Location:categories.php?success=$success");
}

function category_table($dbconn){
	$stmt = $dbconn->prepare("SELECT * FROM category");
	$stmt->execute();
	$result = "";

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$cat_name = $row['category_name'];
			$cat_id = $row['category_id'];

			$result .= "<tr>";
			$result .= '<td>' .$row['category_name']. '</td>';
			$result .= '<td>' .$row['category_id']. '</td>';
			/*$result .= "<td><a href='categories.php?action=edit&category_id=$cat_id'>edit</a> </td>";*/
			$result .= "<td><a href='categories.php?act=delete&category_id=$cat_id'>delete</a></td>";
			$result .= "</tr>";
	}
	return $result;

}

/*	function editCategory($dbconn, $input){

		$stmt = $dbconn->prepare("UPDATE category SET category_name = :c WHERE category_id = :ci");
		$stmt->bindParam(":c", $input['category_name']);
		$stmt->bindParam(":ci", $input['category_id']);
		$stmt->execute();
		$success = "category edited!";
		header("Location:categories.php?success=$success");
	}
*/

function addBooks($dbconn, $add){
	define('MAX_FILE_SIZE', '2097152');

		$ext = ["image/jpg", "image/jpeg", "image/png"];

		$rnd = rand(0000000000, 9999999999);

		$strip_name = str_replace(" ", " _ ", $_FILES['book']['name']);

		$filename = $rnd.$strip_name;
		$destination = 'uploads/'.$filename;

			if (array_key_exists('save', $_POST)) {

				$errors = [];

			
			if (empty($_FILES['book']['name'])) {
				$errors[] = "Please choose a file";
			}

		if ($_FILES['book']['size'] > MAX_FILE_SIZE ) {
			$errors[] = "file size exceeds maximum. maximum: ". MAX_FILE_SIZE;
		}
		if (!in_array($_FILES['book']['type'], $ext)) {
			$errors[] = "invalid file type";
		}
		if (empty($errors)) {
			if (!move_uploaded_file($_FILES['book']['tmp_name'], $destination)) {
				$errors[] = "file upload failed";
			}
		echo "done";
		}
		else{
			foreach ($errors as $err) {
				echo $err. '</br>';
			}
		}
	}
		
		
		$state = $dbconn->prepare("SELECT category_id FROM category WHERE category_name = :c");
		$state->bindParam(":c", $add['category']);
		$state->execute();

		$row = $state->fetch(PDO::FETCH_ASSOC);
		$category_id = $row['category_id'];

		$stmt = $dbconn->prepare("INSERT INTO books(title, author, category_id, price, year_of_publication, isbn, file_path)	VALUES(:ti, :au, :ci, :pr, :yr, :is, :fi)");
		$data = [

			':ti' => $add['title'],
			':au' => $add['author'],
			'ci' => $category_id,
			':pr' => $add['price'],
			':yr' => $add['year_of_publication'],
			':is' => $add['isbn'],
			':fi' => $destination

				];

			$stmt->execute($data);
	}

/*function UploadFile($file, $name, $uploadDir) {
	$data = [];
	$rnd = rand (0000000000,9999999999);

	$strip_name = str_replace (" ","_",$_FILES['pic']['name']);

	$filename = $rnd.$strip_name;
	$destination = $uploadDir .$filename;

	if (!move_uploaded_file($file[$name]['tmp_name'], $destination)){
		$data[] = false;
	} else {
		$data[] = true;
		$data[] = $destination;
	}

	return $data;
}
*/


/*	function fileUpload(){
		#max file size..
		define("MAX_FILE_SIZE", "2097152");
		
		#allowed extension..
		$ext = ["image/jpg", "image/jpeg", "image/png"];

		#be sure a file was selected
		if(empty($_FILES['book']['name'])){
			$errors[] = "Please choose a file";
		}
		#check file size
		if($_FILES['book']['size'] > MAX_FILE_SIZE){
			$errors[] = "File size exceeds maximum. maximum: ".MAX_FILE_SIZE;
		}

		if(!in_array($_FILES['book']['type'], $ext)){
			$errors[] = "Invalid file type";
		}

		
		#generate random number to append
		$rnd = rand(0000000000, 9999999999);

		#strip filename for spaces
		$strip_name = str_replace(" ","_", $_FILES['book']['name']);
		$filename = $rnd.$strip_name;
		$destination = 'uploads/'.$filename;

		if(empty($errors)){
			if (!move_uploaded_file($_FILES['book']['tmp_name'], $destination)){
				$errors[] = "File upload failed";
				return [false, $errors];				
			} else {
				return [true, $destination];
			}
		
		}

}
*/





function view_books($dbconn){
		$stmt = $dbconn->prepare("SELECT * FROM books");
		$stmt->execute();
		$result = "";
		

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$book_id = $row['book_id'];
			$title = $row['title'];
			$author = $row['author'];
			$price = $row['price'];
			$year = $row['year_of_publication'];
			$isbn = $row['isbn'];



			$result .="<tr>";
			
			$result .="<td>".$title."</td>";
			$result .="<td>".$author."</td>";
			$result .="<td>".$price."</td>";
			$result .="<td>".$year."</td>";
			$result .="<td>".$isbn."</td>";
			$result .='<td><img src="'.$row['file_path'].'" height="100" width="100"></td>';



			$result .= "<td><a href='view_books.php?action=edit&book_id=$book_id&title=$title'>edit</a></td>";
			$result .= "<td><a href='view_books.php?act=delete&book_id=$book_id'>delete</a></td>";
			$result .= "<tr>";

		}
		return $result;
}


function deleteBooks($dbconn, $input){
			#insert the data 
		$stmt = $dbconn->prepare("DELETE FROM books WHERE book_id = :id");

		#bind params..
		$stmt->bindParam(":id", $input);
		$stmt->execute();
		$success = "<strong>Book deleted</strong>";
		header("Location:view_books.php?success=$success");
}


function editBooks($dbconn, $input){

		$stmt = $dbconn->prepare("UPDATE books SET title = :ti WHERE book_id = :bi");
		$stmt->bindParam(":ti", $input['title']);
		$stmt->bindParam(":bi", $input['book_id']);
		$stmt->execute();
		$success = " <strong> Book edited </strong>";
		header("Location:view_books.php?success=$success");
	}


 ?>