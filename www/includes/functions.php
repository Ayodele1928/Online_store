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




 ?>