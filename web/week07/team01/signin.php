<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../../modules/dbConnect.php";
  $db = get_db();

  $incorrect = false;

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = 'SELECT password, id FROM week07_user WHERE username=:username';
    $stmnt = $db->prepare($query);
    $stmnt->bindValue(':username', $username);
    $stmnt->execute();

    $db_info = $stmnt->fetch(PDO::FETCH_ASSOC);
    $db_hash = $db_info['password'];
    $db_id = $db_info['id'];

    if (password_verify($password, $db_hash)) {
      $session['w07_user'] = $db_id;
      header('Location: welcome.php');
      die();
    }
    else {
      $incorrect = true;
    }

    // echo "$username and $hash";
    // header('Location: signin.php');
    // die();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <button type="submit">Log In</button>
    <?php
      if ($incorrect) {
        echo "<p>Your login information was incorrect</p>";
      }
    ?>
  </form>
  <a href="signup.php">Sign Up</a>
</body>
</html>