<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  $mismatch = false;

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passmatch = $_POST['passmatch'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $passmatch) {
      $query = 'INSERT INTO week07_user(username, password) VALUES (:username, :password) ON CONFLICT DO NOTHING';
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':username', $username);
      $stmnt->bindValue(':password', $hash);
      $stmnt->execute();

      // echo "$username and $hash";
      header('Location: signin.php');
      die();
    }
    else {
      $mismatch = true;
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="password" name="passmatch" placeholder="Re-type Password" />
    <button type="submit">Submit</button>
  </form>
  <?php if ($mismatch) { ?>
    <p>Passwords do not match</p>
  <?php } ?>
</body>
</html>