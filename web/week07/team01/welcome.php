<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../../modules/dbConnect.php";
  $db = get_db();

  $username = "UNKNOWN_USER";

  function return_to_login() {
    header('Location: signin.php');
    die();
  }

  if (isset($_SESSION['week07_user'])) {
    $id = $_SESSION['week07_user'];
    $query = 'SELECT username FROM week07_user WHERE id=:id';
    $stmnt = $db->prepare($query);
    $stmnt->bindValue(':id', $id);
    $stmnt->execute();

    $username = $stmnt->fetch(PDO::FETCH_ASSOC)['username'];

    // if ($username)
  }
  else {
    return_to_login();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Welcome</title>
</head>
<body>
  <h1>Welcome <?=$username?></h1>
</body>
</html>