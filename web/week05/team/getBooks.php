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
  
  $count = 0;

  echo "[";
  while ($scripRow = $scriptures->fetch(PDO::FETCH_ASSOC)) {
    if ($count > 0) {
      echo ',';
    }
    echo "\n{\n";
    echo "\t'book': \"" . $scripRow['book'] . "\",\n";
    echo "\t'chapter': \"" . $scripRow['chapter'] . "\",\n";
    echo "\t'verse': \"" . $scripRow['verse'] . "\",\n";
    echo "\t'content': \"" . $scripRow['content'] . "\"\n";
    echo '}';
    $count = $count + 1;
  }
  echo ']';
?>