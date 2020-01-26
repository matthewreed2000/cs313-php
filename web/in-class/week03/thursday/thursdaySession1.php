<?php
  // Start the session
  session_start();
?>
<!DOCTYPE html>
<html>
  <body>
    <?php
      // remove previous session variable
      unset($_SESSION['pictureUrl']);

      // Set session variables
      $_SESSION['favcolor'] = "green";
      $_SESSION['favanimal'] = "dolphin";

      // echo that variables have been set
      echo "Session variables have been set";
?>
    <a href="thursdaySession2.php">Check the variables on another page</a>

    <form action="" method="POST">
      <input type="text" name="picture">
      <button type="submit" name="submit">SUBMIT!</button>
    </form>

    <?php // set session variables using a form 
      if (isset($_POST['submit'])) {
        $_SESSION['pictureUrl'] = $_POST['picture'];
      }
    ?>
  </body>
</html>