<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../modules/dbConnect.php";
  $db = get_db();

  $show_error = false;

  function sanitizeInput($input) {
    // TODO
    return $input;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log In</title>
</head>
<body>
  <?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $username = sanitizeInput($_POST['username']);
      $password = sanitizeInput($_POST['password']);

      $statement = $db->prepare("SELECT password FROM public.User
        WHERE username='$username'");
      $statement->execute();

      $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
      echo $dbPass;
    }
  ?>
  <form action="#" method="POST">
    <input type="username" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Log In</button>
  </form>
  <?php if ($show_error) { ?>
    <p>Incorrect username or password</p>
  <?php } ?>
</body>
</html>