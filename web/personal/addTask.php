<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../modules/dbConnect.php";
  $db = get_db();

  require "../modules/verifyPassword.php";

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

    // $statement = $db->prepare("SELECT password FROM UserData
    //   WHERE username='$username'");
    // $statement->execute();

    // $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
    if (!verify_password('UserData', $username, $password)) {
      returnToLogin();
    }
  }
  else {
    returnToLogin();
  }

  // Will add task if POST exists
  if (isset($_POST)) {
    // TODO
    $validForm = isset($_POST['title']) ? !empty($_POST['title']) : 0 &&
                 isset($_POST['descr']) ? !empty($_POST['descr']) : 0;
    if ($validForm) {
      $title = sanitizeInput($_POST['title']);
      $descr = sanitizeInput($_POST['descr']);

      $query = 'INSERT INTO Task(Title, Description)
        VALUES (:title, :descr) RETURNING id';
      
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':title', $title);
      $stmnt->bindValue(':descr', $descr);

      $stmnt->execute();

      if ($taskid = $stmnt->fetch(PDO::FETCH_ASSOC)['id']) {
        $query = 'SELECT id FROM UserData WHERE username=:username';
        $stmnt = $db->prepare($query);
        $stmnt->bindValue(':username', $username);
        $stmnt->execute();

        if ($userid = $stmnt->fetch(PDO::FETCH_ASSOC)['id']) {
          $query = 'INSERT INTO UserTask(UserID, TaskID)
            VALUES (:userid, :taskid)';

          $stmnt = $db->prepare($query);
          $stmnt->bindValue(':taskid', $taskid);
          $stmnt->bindValue(':userid', $userid);

          $stmnt->execute();
        }
      }

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
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <header id="header"></header>
  <main id="content-wrap">
    <div class="jumbotron">
      <form action="" method="POST">
        <input type="text" name="title">
        <input type="text" name="descr">
        <input type="date" name="startdate">
        <input type="time" name="starttime">
        <input type="date" name="enddate">
        <input type="time" name="endtime">
        <input type="text" name="repeat">
        <input type="text" name="priority">
        <button type="submit">Add Task</button>
      </form>
    </div>
  </main>
  <footer id="footer"></footer>
</body>
</html>