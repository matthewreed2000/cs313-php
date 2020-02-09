<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../modules/dbConnect.php";
  $db = get_db();

  function sanitizeSession($input) {
    // TODO
    return $input;
  }

  function returnToLogin() {
    header("Location: index.php", true, 301);
    exit();
  }

  if (isset($_SESSION['frozen_waters_username'])
    && isset($_SESSION['frozen_waters_password'])) {
    $username = sanitizeSession($_SESSION['frozen_waters_username']);
    $password = sanitizeSession($_SESSION['frozen_waters_password']);

    $statement = $db->prepare("SELECT password FROM public.User
      WHERE username='$username'");
    $statement->execute();

    $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
    if ($password != $dbPass) {
      returnToLogin();
    }
  }
  else {
    returnToLogin();
  }

  // Will add task if POST exists
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Task</title>
</head>
<body>
  <main id="content-wrapper">
    <div class="jumbotron">
      <form action="" method="POST">
        <input type="text" name="title">
        <input type="text" name="desc">
        <input type="datetime-local" name="starttime">
        <input type="datetime-local" name="endtime">
        <input type="text" name="repeat">
        <input type="text" name="priority">
        <button type="submit">Add Task</button>
      </form>
    </div>
  </main>
</body>
</html>