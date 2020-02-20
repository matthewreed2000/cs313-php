<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = 'SELECT password FROM week07_user WHERE username=:username';
    $stmnt = $db->prepare($query);
    $stmnt->bindValue(':username', $username);
    $stmnt->execute();

    $db_hash = $stmnt->fetch(PDO::FETCH_ASSOC)['password'];

    if (password_verify($password, $db_hash)) {
      echo "CORRECT";
    }
    else {
      echo "INCORRECT";
    }

    // echo "$username and $hash";
    // header('Location: signin.php');
    // die();
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
    <button type="submit">Log In</button>
  </form>
</body>
</html>