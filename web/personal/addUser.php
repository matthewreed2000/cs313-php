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

  // $query = 'INSERT INTO week07_user(username, password) VALUES (:username, :password) ON CONFLICT DO NOTHING'

  // if (isset($_SESSION['frozen_waters_username'])
  //   && isset($_SESSION['frozen_waters_password'])) {
  //   $username = sanitizeSession($_SESSION['frozen_waters_username']);
  //   $password = sanitizeSession($_SESSION['frozen_waters_password']);

  //   $statement = $db->prepare("SELECT password FROM UserData
  //     WHERE username='$username'");
  //   $statement->execute();

  //   $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
  //   if ($password != $dbPass) {
  //     returnToLogin();
  //   }
  // }
  // else {
  //   returnToLogin();
  // }
  require "../modules/dbConnect.php";
  $db = get_db();

  $error = NULL;

  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passmatch'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passmatch = $_POST['passmatch'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $passmatch) {
      $query = 'INSERT INTO UserData(username, password) VALUES (:username, :password) ON CONFLICT DO NOTHING';
      $stmnt = $db->prepare($query);
      $stmnt->bindValue(':username', $username);
      $stmnt->bindValue(':password', $hash);
      $stmnt->execute();

      returnToLogin();
    }
    else {
      $error = 'mismatch';
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username" required />
    <br />
    <input type="password" name="password" placeholder="Password" required />
    <?php if ($error != NULL) { ?>
      <p>*</p>
    <?php } ?>
    <br />
    <input type="password" name="passmatch" placeholder="Re-type Password" required />
    <?php if ($error != NULL) { ?>
      <p>*</p>
    <?php } ?>
    <br />
    <button type="submit">Submit</button>
  </form>
  <p id='output'></p>
  <?php if ($error == 'mismatch') { ?>
    <p>Passwords do not match</p>
  <?php } ?>
</body>
</html>