<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../modules/dbConnect.php";
  $db = get_db();

  require "../modules/verifyPassword.php";

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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Calendar</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
  <?php include "modules/header.php";?>
  <main id="content-wrap">
    <h1><?php
      $statement = $db->prepare("SELECT DisplayName FROM UserData
        WHERE username='$username'");
      $statement->execute();
      echo $statement->fetch(PDO::FETCH_ASSOC)['displayname'];
    ?>'s Calendar</h1>
    <div class="circleButton"><a href="addTask.php">+</a></div>
    <div class="calendarHolder">
      <div><p><b>Sunday</b></p></div>
      <div><p><b>Monday</b></p></div>
      <div><p><b>Tuesday</b></p></div>
      <div><p><b>Wednesday</b></p></div>
      <div><p><b>Thursday</b></p></div>
      <div><p><b>Friday</b></p></div>
      <div><p><b>Saturday</b></p></div>
      <?php
        $firstDayOfWeek = date('w', strtotime('-'. date('d', time()-24*60*60) .' days'));

        for ($i = 0; $i < $firstDayOfWeek; $i++) {
      ?>
        <div class="spacer"></div>
      <?php } ?>
      <?php
        $numdays = date('t');
        for($i = 1; $i < $numdays + 1; $i++) {
      ?>
        <div>
          <p><?=$i?></p>
          <?php
            $date = date("Y_m_") . sprintf("%02d", $i);
            $statement = $db->prepare("
              SELECT t.ID, t.Title FROM Task t
              INNER JOIN UserTask ut ON t.id = ut.TaskID
              INNER JOIN UserData u ON ut.UserID = u.id
              WHERE u.username = '$username'
              AND t.SetDate = '$date'");
            $statement->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <a href="task.php?id=<?=$row['id']?>"><?=$row['title']?></a><br>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </main>
  <?php include "modules/footer.php";?>
</body>
</html>