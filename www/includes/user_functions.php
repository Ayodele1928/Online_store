<?php
function displayTopBookImage($dbconn, $dir){
	$result = "";
	$stmt = $dbconn->prepare("SELECT * FROM book WHERE file_path = :f");
	$stmt->bindParam(":f", $dir);
    $stmt->execute();
    $result .= '<div class="display-book" style="background: url('.$dir.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>';
	return $result;
}
function displayTopBookInfo($dbconn, $dir){
	$result = "";
	$stmt = $dbconn->prepare("SELECT * FROM book WHERE file_path = :f");
	$stmt->bindParam(":f", $dir);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $title = $row['title'];
    $author = $row['author'];
    $price = '£'.$row['price'];
         
    $result .= '<h2 class="book-title">'.$title.'</h2>'.'<h3 class="book-author">'."by ".$author.'</h3>'.'<h3 class="book-price">'.$price.'</h3>';
		}
		return $result;
}
function trendingBook($dbconn){ 
	$result = "";
    $stmt = $dbconn->prepare("SELECT * FROM book where flag = 'Trending'");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $book_id = $row['book_id'];
    $price = '£'.$row['price'];
    $filepath = $row['file_path'];
    $result .= "<li class='book'><a href='bookpreview.php?book_id=$book_id'><div class='book-cover'><img src='".$filepath."' height='210' width='150'/></div></a>"."<div class='book-price'><p>".$price."</p></div></li>";
    }
    return $result;
}
function topsellingBook($dbconn){ 
	$result = "";
    $stmt = $dbconn->prepare("SELECT * FROM book where flag = 'Top-Selling'");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $book_id = $row['book_id'];
    $price = '£'.$row['price'];
    $filepath = $row['file_path'];
    $result .= "<li class='book'><a href='bookpreview.php?book_id=$book_id'><div class='book-cover'><img src='".$filepath."' height='210' width='150'/></div></a>"."<div class='book-price'><p>".$price."</p></div></li>";
    }
	return $result;
}
function displayCatalogueCategory($dbconn){
	$result = "";
    $stmt = $dbconn->prepare("SELECT * FROM category");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $categoryname = $row['category_name'];
    $result .= '<a href="#"><li class="category">'.$categoryname.'</li></a>';
    }
    return $result;
}
function displayAllBook($dbconn){
	$result = "";
	$stmt = $dbconn->prepare("SELECT * FROM book");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $book_id = $row['book_id'];
    $price = '£'.$row['price'];
    $filepath = $row['file_path'];
    $result .= "<li class='book'><a href='bookpreview.php?book_id=$book_id'><div class='book-cover'><img src='".$filepath."' height='210' width='150'/></div></a>"."<div class='book-price'><p>".$price."</p></div></li>";
    }
    return $result;
}
function displayRecentlyViewed($dbconn){
	$result = "";
	$stmt = $dbconn->prepare("SELECT * FROM book WHERE flag = 'Top-selling' AND price > 81");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $book_id = $row['book_id'];
    $price = '£'.$row['price'];
    $filepath = $row['file_path'];
    $result .= "<li class='book'><a href='bookpreview.php?book_id=$book_id'><div class='book-cover'><img src='".$filepath."' height='210' width='150'/></div></a>"."<div class='book-price'><p>".$price."</p></div></li>";
    }
    return $result;
}
function getBookByID($dbconn, $bookid){
	$stmt = $dbconn->prepare("SELECT * FROM book WHERE book_id = :b");
	$stmt->bindParam(":b", $bookid);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row;
	}
function displayError($errs, $val){
	$result = "";
	if(isset($errs[$val])){
	$result = '<span class="err" style="top: -14px; font-size: 12px; left: 105px; color:red;">'.$errs[$val].'</span>';
	}
	return $result;
}
function doesUserEmailExist($dbconn, $email){
	$result = false;
	$stmt = $dbconn->prepare("SELECT email FROM user WHERE email=:e");
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
/*function doUserRegister($dbconn, $input){
	#hash the password
	$hash = password_hash($input['password'], PASSWORD_BCRYPT);
	#insert data
	$stmt = $dbconn->prepare("INSERT INTO user(firstname, lastname, email, username, hash) VALUES(:fn, :ln, :e, :u, :h)");
	#bind params
	$data = [
				':fn' => $input['firstname'],
				':ln' => $input['lastname'],
				':e' => $input['email'],
				':u' => $input['username'],
				':h' => $hash
			];
	$stmt->execute($data);
	$success = "Successfully Registered";
	header("Location:userlogin.php?success=$success");
}*/
function doUserLogin($dbconn, $enter){
	#data
	$result = [];
	#query data
	$statement = $dbconn->prepare("SELECT * FROM user WHERE email=:e");
	#bind params
	$statement->bindParam(":e", $enter['email']);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	#get number of rows
	$count = $statement->rowCount();
	if($count != 1 || !password_verify($enter['password'],$row['hash'])) {
		$result[] = false;
	} else {
		$result[] = true;
		$result[] = $row;
	}
	return $result;
}
function authenticate() {
		if(!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
			header("Location:userlogin.php");
		}
	}
/*function redirect($loc) {
	header("Location: ".$loc);
}*/
function getUserByID($dbconn, $userid){
	$stmt = $dbconn->prepare("SELECT * FROM user WHERE user_id = :u");
	$stmt->bindParam(":u", $userid);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row;
	}
function addToCart($dbconn, $bookid){
	$result ="";
	$stmt = $dbconn->prepare("SELECT * FROM book WHERE book_id = :b");
    $stmt->bindParam(":b", $bookid);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $filepath = $row['file_path'];
    $title = $row['title'];
    $author = $row['author'];
    $price = '£'.$row['price'];
    $result .= '<td><div class="book-cover" style="background: url('.$filepath.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div></td>'.
        '<td><p class="book-price">'.$price.'</p></td>'.
        '<td><p class="quantity">'."3".'</p></td>'.
        '<td><p class="total">'."$600".'</p></td>';
    }
    return $result;
}
?>