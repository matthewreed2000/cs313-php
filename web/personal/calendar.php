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
    $numdays = date('t');
    
    $statement = $db->prepare("SELECT SetDate FROM public.UserTask
      WHERE UserID=(SELECT ID FROM public.User WHERE username='$username')");
    $statement->execute();

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      echo $row['setdate'] . '<br>';
    }

    for($i = 1; $i < $numdays + 1; $i++) {
      $date = date("%y_");
      echo $date;
      $statement = $db->prepare("
        SELECT t.Title FROM PUBLIC.Task t
        INNER JOIN PUBLIC.UserTask ut ON t.id = ut.TaskID
        INNER JOIN PUBLIC.User u ON ut.UserID = u.id
        WHERE u.username = '$username'
        AND ut.SetDate = '$date'");
  ?>
    <p><?=$i?></p>
  <?php } ?>
</body>
</html>