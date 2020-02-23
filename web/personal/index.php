<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  require "../modules/dbConnect.php";
  $db = get_db();

  require "../modules/verifyPassword.php";

  $show_error = false;

  function sanitizeInput($input) {
    // TODO
    return $input;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log In</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div id="page-container">
    <?php include "modules/header.php";?>
    <main id="content-wrap">
      <div class="jumbotron">
        <?php
          if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = sanitizeInput($_POST['username']);
            $password = sanitizeInput($_POST['password']);

            // $statement = $db->prepare("SELECT password FROM UserData
            //   WHERE username='$username'");
            // $statement->execute();

            // $dbPass = $statement->fetch(PDO::FETCH_ASSOC)['password'];
            if (verify_password('UserData', $username, $password)) {
              $_SESSION['frozen_waters_username'] = $username;
              $_SESSION['frozen_waters_password'] = $password;

              header("Location: calendar.php", true, 301);
              exit();
            }
            else {
              $show_error = true;
            }
          }
        ?>
        <form action="" method="POST">
          <input type="username" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Log In</button>
        </form>
        <a href="addUser.php">Register Account</a>
        <p>For testing purposes, use the username "test" and the password "test123"</p>
        <?php if ($show_error) { ?>
          <p>Incorrect username or password</p>
        <?php } ?>
      </div>
    </main>
  </div>
  <?php include "modules/footer.php";?>
</body>
</html>