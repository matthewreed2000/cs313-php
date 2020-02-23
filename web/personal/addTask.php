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

  function addProperty($id, $title, $value) {
    $db = get_db();

    $query = "UPDATE Task SET $title=:value WHERE id=:id";
    $stmnt = $db->prepare($query);
    $stmnt->bindValue(':value', $value);
    $stmnt->bindValue(':id', $id);

    $stmnt->execute();
  }

  function addPostProperty($id, $title, $key=NULL) {
    if (is_null($key)) {
      $key=$title;
    }

    if (isset($_POST[$key])) {
      if (!empty($_POST[$key]))
        $value = sanitizeInput($_POST[$key]);
        // addProperty($id, $title, $value);
      }
    }
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
    // $validForm = isset($_POST['title']) ? !empty($_POST['title']) : 0 &&
    //              isset($_POST['descr']) ? !empty($_POST['descr']) : 0;
    $validForm = isset($_POST['title']) ? !empty($_POST['title']) : 0;
    if ($validForm) {
      $taskid = NULL;
      $title = sanitizeInput($_POST['title']);
      // $descr = sanitizeInput($_POST['descr']);

      // $query = 'INSERT INTO Task(Title, Description)
      //   VALUES (:title, :descr) RETURNING id';

      $query = 'INSERT INTO Task(Title)
         VALUES (:title) RETURNING id';
      
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':title', $title);
      // $stmnt->bindValue(':descr', $descr);

      $stmnt->execute();

      if ($taskid = $stmnt->fetch(PDO::FETCH_ASSOC)['id']) {
        $query = 'SELECT id FROM UserData WHERE username=:username';
        $stmnt = $db->prepare($query);
        $stmnt->bindValue(':username', $username);
        $stmnt->execute();

        if ($userid = $stmnt->fetch(PDO::FETCH_ASSOC)['id']) {
          $query = 'INSERT INTO UserTask(UserID, TaskID)
            VALUES (:userid, :taskid) RETURNING id';

          $stmnt = $db->prepare($query);
          $stmnt->bindValue(':taskid', $taskid);
          $stmnt->bindValue(':userid', $userid);

          $stmnt->execute();
        }
      }

      if (!is_null($taskid)) {
        // addPostProperty($taskid, 'Description', 'descr');
        // addPostProperty($taskid, 'SetDate', 'startdate');
        // addPostProperty($taskid, 'starttime');
        // addPostProperty($taskid, 'EndDateOffset', 'enddate');
        // addPostProperty($taskid, 'endtime');
        // addPostProperty($taskid, 'repeat');
        // addPostProperty($taskid, 'priority');
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
  <?php include "modules/header.php";?>
  <main id="content-wrap">
    <div class="jumbotron">
      <form action="" method="POST">
        <input type="text" name="title" placeholder="Task Title" required>
        <textarea name="descr" placeholder="Description"></textarea>
        <div class="half">
          <input type="date" name="startdate" placeholder="Start Date">
          <input type="time" name="starttime" placeholder="Start Time">
        </div>
        <div class="half">
          <input type="date" name="enddate" placeholder="End Date">
          <input type="time" name="endtime" placeholder="End Time">
        </div>
        <input type="text" name="repeat" placeholder="Repeat Pattern">
        <input type="number" name="priority" placeholder="Priority">
        <button type="submit">Add Task</button>
      </form>
    </div>
  </main>
  <?php include "modules/footer.php";?>
</body>
</html>