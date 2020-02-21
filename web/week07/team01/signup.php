<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  $error = NULL;

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passmatch = $_POST['passmatch'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $passmatch) {
      if (preg_match('/[0-9]+/', $password)) {
        if (strlen($password) >= 7) {
          $query = 'INSERT INTO week07_user(username, password) VALUES (:username, :password) ON CONFLICT DO NOTHING';
          $stmnt = $db->prepare($query);
          $stmnt->bindValue(':username', $username);
          $stmnt->bindValue(':password', $hash);
          $stmnt->execute();

          // echo "$username and $hash";
          header('Location: signin.php');
          die();
        }
        else {
          $error = 'length';
        }
      }
      else {
        $error = 'number';
      }
    }
    else {
      $error = 'mismatch';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <style>
    p {
      display: inline-block;
      color: red;
      margin: 0;
    }
  </style>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username" />
    <br />
    <input type="password" name="password" placeholder="Password" oninput="pass_strength(this);"/>
    <?php if ($error != NULL) { ?>
      <p>*</p>
    <?php } ?>
    <br />
    <input type="password" name="passmatch" placeholder="Re-type Password" />
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
  <?php if ($error == 'number') { ?>
    <p>Password must contain a number</p>
  <?php } ?>
  <?php if ($error == 'length') { ?>
    <p>Password must contain at least 7 characters</p>
  <?php } ?>
  <script>
    function pass_strength(input) {
      output = document.getElementById('output');
      if (len(input) < 7) {
        output.innerHTML = 'Greater than 7';
      }
      if (!(input.match(/\d+/g))) {
        output.innerHTML = 'Must contain at least 1 number';
      }
    }
  </script>
</body>
</html>