<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../modules/dbConnect.php";
  $db = get_db();

  function sanitizeInput($input) {
    // TODO
    return $input;
  }

  function sanitizeSession($input) {
    return sanitizeInput($input);
  }

  function returnToLogin() {
    header("Location: index.php", true, 301);
    exit();
  }

  // if (isset($_SESSION['frozen_waters_username'])
  //   && isset($_SESSION['frozen_waters_password'])) {
  //   $username = sanitizeSession($_SESSION['frozen_waters_username']);
  //   $password = sanitizeSession($_SESSION['frozen_waters_password']);

  //   $statement = $db->prepare("SELECT password FROM UserData
  //     WHERE username='$username'");
  //   $statement->execute();

  //   $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
  //   if ($password != $dbPass) {
  //     returnToLogin();
  //   }
  // }
  // else {
  //   returnToLogin();
  // }
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

</body>
</html>