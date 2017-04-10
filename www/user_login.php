<?php 
include 'includes/user_header.php';


 ?>
  <!-- main content starts here -->
  <div class="main">
    <div class="login-form">
      <form class="def-modal-form">
        <div class="cancel-icon close-form"></div>
        <label for="login-form" class="header"><h3>Login</h3></label>
        <input type="text" class="text-field email" placeholder="Email">
        <p class="form-error">invalid email</p>
        <input type="password" class="text-field password" placeholder="Password">
        <!--clear the error and use it later just to show you how it works -->
        <p class="form-error">wrong password</p>
        <input type="submit" class="def-button login" value="Login">
        <a href="user_reg.php"><p class="login-option">Don't have an account? Register</p></a>
      </form>
    </div>
  </div>
  <!-- footer starts here-->
<?php
include 'includes/user_footer.php';

?>
