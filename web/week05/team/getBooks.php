<?php
  require "../../modules/dbConnect.php";
  $db = get_db();

  $book = $_POST['book'];

  $scriptures = $db->prepare("SELECT * FROM scripture WHERE book = '$book'");
  $scriptures->execute();
  while ($scripRow = $scriptures->fetch(PDO::FETCH_ASSOC)) {
    echo "$scriptRow['book']";
  }
?>