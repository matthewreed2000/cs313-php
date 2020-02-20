<?php
  if (isset($_POST['username'] && isset($_POST['password']))) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    echo "$username and $hash";
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <button type="submit">Submit</button>
  </form>
</body>
</html>