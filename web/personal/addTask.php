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
  if (isset($_POST)) {
    // TODO
    $validForm = isset($_POST['title']) &&
                 isset($_POST['descr']);
    if ($validForm) {
      $title = sanitizeInput($_POST['title']);
      $descr = sanitizeInput($_POST['descr']);

      $query = 'INSERT INTO PUBLIC.task(Title, Description)
        VALUES (:title, :descr) RETURNING id';
      
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':title', $title);
      $stmnt->bindValue(':descr', $descr);

      $stmnt->execute;

      echo $stmnt->fetch(PDO::FETCH_ASSOC)['id'];

      header("Location: calendar.php", true, 301);
      exit();
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Task</title>
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
  <main id="content-wrapper">
    <div class="jumbotron">
      <form action="" method="POST">
        <input type="text" name="title">
        <input type="text" name="descr">
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