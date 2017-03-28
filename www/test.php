<?php

define('DBNAME', 'test');
define('DBUSER'; 'root');
define('DBPASS', '@@yodele'); 
$conn = new PDO('mysql:host=localhost;dbname=' .DBNAME, DBUSER, DBPASS);


 ?>