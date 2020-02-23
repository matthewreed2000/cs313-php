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

  function deleteId($user, $id) {
    $db = get_db();

    // Make sure that the id is linked with the user
    $query = "
      SELECT t.id FROM Task t
      INNER JOIN UserTask ut ON t.id = ut.TaskID
      INNER JOIN UserData u ON ut.UserID = u.id
      WHERE u.username = :user
      AND t.id = :id";
    $stmnt = $db->prepare($query);

    $stmnt->bindValue(':user', $user);
    $stmnt->bindValue(':id', $id);

    $stmnt->execute();
    $new_id = $stmnt->fetch(PDO::FETCH_ASSOC)['id'];

    // Delete the task if it does belong to the user
    if ($new_id != '') {
      $query = "DELETE FROM Task WHERE id=:new_id";
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':new_id', $new_id);
      $stmnt->execute();
    }

    header("Location: calendar.php", true, 301);
    exit();
  }

  if (isset($_SESSION['frozen_waters_username'])
    && isset($_SESSION['frozen_waters_password'])) {
    // Get user login info when page loads
    $username = sanitizeSession($_SESSION['frozen_waters_username']);
    $password = sanitizeSession($_SESSION['frozen_waters_password']);

    // If the login info is wrong, return the user to the login page
    // $statement = $db->prepare("SELECT password FROM UserData
    //   WHERE username=:username");
    // $statement->bindValue(':username', $username);
    // $statement->execute();

    // $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
    if (!verify_password('UserData', $username, $password)) {
      returnToLogin();
    }

    // If the task does not belong to the user, return the user to the
    // login page
    if (isset($_GET['id'])) {
      $id = sanitizeInput($_GET['id']);
      $statement = $db->prepare("
        SELECT t.* FROM Task t
        INNER JOIN UserTask ut ON t.id = ut.TaskID
        INNER JOIN UserData u ON ut.UserID = u.id
        WHERE u.username = '$username'
        AND t.id = '$id'");
      $statement->execute();
      $info = $statement->fetch(PDO::FETCH_ASSOC);

      if (isset($_POST['deleteStatus'])) {
        $deleteStatus = sanitizeInput($_POST['deleteStatus']);
        if ($deleteStatus == true) {
          deleteId($username, $id);
        }
      }
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
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <?php include "modules/header.php";?>
  <main id="content-wrap">
    <div class="jumbotron">
      <?php if (isset($info)) { ?>
        <h1><?=$info['title']?></h1>
    </div>
      <p><?=$info['description']?></p>
      <form action="" method="POST">
        <button type="submit" name="deleteStatus" value="true">Delete Task</button>
      </form>
    <?php } else { ?>
      <p>You are not allowed to view this task</p>
    <?php } ?>
  </main>
  <?php include "modules/footer.php";?>
</body>
</html>