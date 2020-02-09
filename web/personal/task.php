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

  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    // Get user login info when page loads
    $username = sanitizeSession($_SESSION['username']);
    $password = sanitizeSession($_SESSION['password']);

    // If the login info is wrong, return the user to the login page
    $statement = $db->prepare("SELECT password FROM public.User
      WHERE username='$username'");
    $statement->execute();

    $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
    if ($password != $dbPass) {
      returnToLogin();
    }

    // If the task does not belong to the user, return the user to the
    // login page
    if (isset($_GET['id'])) {
      $id = sanitizeInput($_GET['id']);
      $statement = $db->prepare("
        SELECT * FROM PUBLIC.Task t
        INNER JOIN PUBLIC.UserTask ut ON t.id = ut.TaskID
        INNER JOIN PUBLIC.User u ON ut.UserID = u.id
        WHERE u.username = '$username'
        AND t.id = '$id'");
      $statement->execute();
      $info = $statement->fetch(PDO::FETCH_ASSOC);
      print_r($info);
    }
  }
  else {
    returnToLogin();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Task</title>
</head>
<body>
  <?php
    $statement = $db->prepare("SELECT * FROM PUBLIC.Task WHERE ID=$_GET['id']");
  ?>
</body>
</html>