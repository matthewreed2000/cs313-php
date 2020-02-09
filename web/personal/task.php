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

  if (isset($_SESSION['frozen_waters_username'])
    && isset($_SESSION['frozen_waters_password'])) {
    // Get user login info when page loads
    $username = sanitizeSession($_SESSION['frozen_waters_username']);
    $password = sanitizeSession($_SESSION['frozen_waters_password']);

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
        SELECT t.* FROM PUBLIC.Task t
        INNER JOIN PUBLIC.UserTask ut ON t.id = ut.TaskID
        INNER JOIN PUBLIC.User u ON ut.UserID = u.id
        WHERE u.username = '$username'
        AND t.id = '$id'");
      $statement->execute();
      $info = $statement->fetch(PDO::FETCH_ASSOC);
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
  <?php if (isset($info)) { ?>
    <h1><?=$info['title']?></h1>
    <p><?=$info['description']?></p>
  <?php } else { ?>
    <p>You are not allowed to view this task</p>
    <a href="calendar.php">Return to Calendar</a>
  <?php } ?>
</body>
</html>