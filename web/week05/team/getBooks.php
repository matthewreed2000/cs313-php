<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  if (isset($_POST['book'])) {
    $book = $_POST['book'];
  }
  else {
    $book = "";
  }

  $scriptures = $db->prepare("SELECT * FROM scripture WHERE book = '$book'");
  $scriptures->execute();
  // while ($scripRow = $scriptures->fetch(PDO::FETCH_ASSOC)) {
  //   echo "$scriptRow['book']";
  // }
?>