<?php

function fileUpload($dum_fil, $dum_err, $dum_name){
	#max file size..
	define("MAX_FILE_SIZE", "2097152");
	
	#allowed extension..
	$ext = ["image/jpg", "image/jpeg", "image/png"];

	#be sure a file was selected
	if(empty($dum_fil[$dum_name]['name'])){
		$dum_err[] = "Please choose a file";
	}
	#check file size
	if($dum_fil[$dum_name]['size'] > MAX_FILE_SIZE){
		$dum_err[] = "File size exceeds maximum. maximum: ".MAX_FILE_SIZE;
	}

	if(!in_array($dum_fil[$dum_name]['type'], $ext)){
		$dum_err[] = "Invalid file type";
	}

	
	#generate random number to append
	$rnd = rand(0000000000, 9999999999);

	#strip filename for spaces
	$strip_name = str_replace(" ","_", $dum_fil[$dum_name]['name']);
	$filename = $rnd.$strip_name;
	$destination = 'uploads/'.$filename;

	if(empty($dum_err)){
		if (!move_uploaded_file($dum_fil[$dum_name]['tmp_name'], $destination)){
			$dum_err[] = "File upload failed";
			
		}
		echo "done";
	}else{
		foreach ($dum_err as $err) {
			echo $err. '<br/>';
			
		}
	}

}


/*
if(array_key_exists('save', $_POST)){
	$errors =[];

	#be sure a file was selected..
	if(empty($_FILES['pic']['name'])){
		$errors[] = "Please choose a file";
	}

	#check file size..
	if($_FILES['pic']['size'] > MAX_FILE_SIZE){
		$errors[] = "File size exceeds maximum. maximum: ".MAX_FILE_SIZE;
	}
	#check extension
	if(!in_array($_FILES['pic']['type'], $ext)){
		$errors[] = "Invalid file type";
	}

	#generate random number to append
	$rnd = rand(0000000000, 9999999999);

	#strip filename for spaces
	$strip_name =str_replace("", "_", $_FILES['pic']['name']);

	$filename = $rnd.$strip_name;
	$destination = 'uploads/'.$filename;

	if(!move_uploaded_file($_FILES['pic']['tmp_name'], $destination)){
		$errors[] = "file upload failed";
	}
	if(empty($errors)){
		echo "Done";
	}else{
		foreach ($errors as $err) {
			echo $err. '<br/>';
		}
	}
}
*/
?>