<?php
  require "dbConnect.php";
  function verify_password($user_table, $username, $password) {
    $db = get_db();

    $query = 'SELECT password FROM :user_table WHERE username=:username';
    $stmnt = $db->prepare($query);
    $stmnt->bindValue(':user_table', $user_table);
    $stmnt->bindValue(':username', $username);
    $stmnt->execute();

    $db_info = $stmnt->fetch(PDO::FETCH_ASSOC);
    $db_hash = $db_info['password'];

    if (password_verify($password, $db_hash)) {
      return true;
    }
    else {
      return false;
    }
  }
?>