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

  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = sanitizeSession($_SESSION['username']);
    $password = sanitizeSession($_SESSION['password']);

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
?>
<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
</head>
<body>
  <?php
    for($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, 2, 2020); $i++) {
  ?>
    <p><?=$i?></p>
  <?php } ?>
</body>
</html>