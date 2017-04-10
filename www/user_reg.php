 <?php 
$page_title = "Registration";
  #include db
  include 'includes/db.php';

    #include functions
   include 'includes/functions.php';

    #include header for users
    include 'includes/user_header.php';
  
$errors = [];
 if(array_key_exists('register', $_POST)){
    #Cache errors
    $errors = [];
    #validate first name
    if(empty($_POST['fname'])){
        $errors['fname'] = "please enter first name";
    }
    if(empty($_POST['lname'])){
        $errors['lname'] = "please enter last name";
    }
    if(empty($_POST['email'])){
        $errors['email'] = "please enter email";
    }
     if(empty($_POST['username'])){
        $errors['username'] = "please enter username";
    }
  
    if(doesEmailExist($conn, $_POST['email'])){
        $errors['email'] = "email already exists";
    }
    if(empty($_POST['password'])){
        $errors['password'] = "please enter password";
    }
    if($_POST['password'] != $_POST['pword']){
        $errors['pword'] = "password do not match";
    }
    if(empty($errors)){
      //echo $_POST['fname'];
      //acess database
      $clean = array_map('trim', $_POST);
      #register user
       doUserRegister($conn, $clean);
  
    }
      
}
 ?>


  <!-- main content starts here -->
  <div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="post" action="user_reg.php">
        <div class="cancel-icon close-form"></div>
        <label for="registration-from" class="header"><h3>User Registration</h3></label>

        <?php if(isset($errors['fname'])){echo '<span class="form-error">'.$errors['fname']. '</span>' ; } ?>
        <input type="text" class="text-field first-name"  placeholder="Firstname" name="fname"/>

        <?php if(isset($errors['lname'])){echo '<span class="form-error">'.$errors['lname']. '</span>' ; } ?>
        <input type="text" class="text-field last-name" placeholder="Lastname" name="lname"/>

        <?php if(isset($errors['email'])){echo '<span class="form-error">'.$errors['email']. '</span>' ; } ?>
        <input type="email" class="text-field email" placeholder="Email" name="email"/>

       <?php if(isset($errors['username'])){echo '<span class="form-error">'.$errors['username']. '</span>' ; } ?>
        <input type="text" class="text-field username" placeholder="Username" name="username"/>


        <?php if(isset($errors['password'])){echo '<span class="form-error">'.$errors['password']. '</span>' ; } ?>
        <input type="password" class="text-field password" placeholder="Password" name="password"/>

        <?php if(isset($errors['pword'])){echo '<span class="form-error">'.$errors['pword']. '</span>' ; } ?>
        <input type="password" class="text-field confirm-password" placeholder="Confirm Password" name="pword"/>

        <input type="submit" name="register" class="def-button" value="Register"/>
        <p class="login-option">Have an account already? Login</p>
      </form>
    </div>
  </div>
  <!-- footer starts here-->
<?php
    include 'includes/user_footer.php';

?>
</body>
</html>