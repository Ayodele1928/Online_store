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
					

			//$hash = password_hash($enter['password'], PASSWORD_BCRYPT);

			
			# prepared statement
			$statement = $dbconn->prepare("SELECT * FROM admin WHERE email=:em");
			
			# bind params
			$statement->bindParam(":em", $enter['email']);
			$statement->execute();

			
			$count = $statement->rowCount();
			

			if($count == 1) {
					$row = $statement->fetch(PDO::FETCH_ASSOC);

					if(password_verify($enter['password'], $row['hash'])){

					$_SESSION['id'] = $row['admin_id'];
					$_SESSION['email']	= $row['email'];

					header("Location:home.php");
				}
			 else {

				$success = "<strong>Category sucessfully added</strong>";
				header("Location:categories.php?success=$success");
			}

			
		}
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
			$result .= "<td><a href='categories.php?action=delete&category_id=$cat_id'>delete</a> </td>";
			$result .= "</tr>";
	}
	return $result;

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

	function addBooks($dbconn, $input){
		

	#insert the data 
	$stmt = $dbconn->prepare("INSERT INTO books(title, author, price, image_location, year_of_pub, isbn) VALUES(:ti, :au, :pr, :il, :y, :is)");

		#bind params..
		$data = [
			':ti' => $input['title'],
			':au' => $input['author'],
			':pr' => $input['price'],
			':il' => $input['price'],
			':y' => $input['year_of_pub'],
			':is' => $input['isbn'],
			];

			$stmt->execute($data);

		
	}

	function fileUpload(){
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






function view_books($dbconn){
		$result = "";
	$stmt = $dbconn->prepare("SELECT * FROM books");
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$bk_id = $row['book_id'];
			$title = $row['title'];
			$author = $row['author'];
			$price = $row['price'];
			$year = $row['year_of_pub'];
			$isbn = $row['isbn'];

			$statement = $dbconn->prepare("SELECT category_name FROM category WHERE category_id=:ci");
			$statement->bindParam(":ci", $row['category_id']);
			$statement->execute();
			$row1 = $statement->fetch(PDO::FETCH_ASSOC);

			$result .= "<tr>";
			$result .= '<td>' .$row['book_id']. '</td>';
			$result .= '<td>' .$row['title']. '</td>';
			$result .= '<td>' .$row['author']. '</td>';
			$result .= '<td>' .$row1.'</td>';
			#$result .= '<td>' .$row['category_name']. '</td>';
			$result .= '<td>' .$row['price']. '</td>';
			$result .= '<td>' .$row['year_of_pub']. '</td>';
			$result .= '<td>' .$row['isbn']. '</td>';
			#$result .= '<td><img src="'.$row['file_path'].'" height="60" width="60"></td>';
			$result .= "<td><a href='view_books.php?action=edit&book_id=$bk_id&title=$title&author=$author&price=$price&year_of_pub=$year&isbn=$isbn'>edit</a> </td>";
			$result .= "<td><a href='view_books.php?action=delete&category_id=$bk_id'>delete</a> </td>";
			$result .= "</tr>";
	}
	return $result;

}





 ?>