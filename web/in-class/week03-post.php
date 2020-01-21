<?php
  $email = htmlspecialchars($_POST["emailForPHP"]);
  $password = htmlspecialchars($_POST["passwordForPHP"]);

  echo "Here is your email $email, and your password is $password";
?>