<?php
session_start();
#include db
include 'includes/db.php';
#include function
include 'includes/user_functions.php';

include 'includes/user_header.php';

include 'includes/functions.php';
#cache errors
    $errors = [];
  if(array_key_exists('login', $_POST)){
    #validate email
    if(empty($_POST['email'])){
      $errors['email'] = "Invalid email"; 
    }
    if(empty($_POST['password'])){
      $errors['password'] = "Wrong password"; 
    }
if(empty($errors)){
      // do database stuff
      $clean = array_map('trim', $_POST);
      #calls the admin login function to return a true boolean and the record of the login user
      $chk = doUserLogin($conn, $clean);
      if($chk[0]) {
        # set sessions for user
        $_SESSION['id'] = $chk[1]['user_id'];
        $_SESSION['email'] = $chk[1]['email'];
        $_SESSION['name'] = $chk[1]['firstname']." ".$chk[1]['lastname'];
        redirect("catalogue.php");
      } else {
        redirect('user_login.php?msg="Incorrect email and/or password"');
        }
    
      }
}
?>


  <!-- main content starts here -->
  <div class="main">
    <div class="login-form">

      <form class="def-modal-form" action ="user_login.php" method ="POST">

        <div class="cancel-icon close-form"></div>

        <label for="login-form" class="header"><h3>User Login</h3></label>

        <input type="text" name="email" class="text-field email" placeholder="Email">

        <p class="form-error"> <?php $display = displayErrors($errors, 'email'); echo $display; ?> </p>

        
        <input type="password" name="password" class="text-field password" placeholder="Password">

        <p class="form-error"> <?php $display = displayErrors($errors, 'password'); echo $display; ?> </p>


        <!--clear the error and use it later just to show you how it works -->
       

        <input type="submit" name="login" class="def-button login" value="Login">
        <p class="login-option">Dont have an account? <a href="user_reg.php"> Register </a></p>

      </form>
    </div>
  </div>
  <!-- footer starts here-->

  </div>
</body>
</html>