<?php 
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  $statement = $db->prepare("SELECT name FROM w5_EVENT");
  $statement->execute();

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    echo "<p>" . $row['name'] . "</p>";
    echo "<img src=\"";
    echo $row['image'];
    echo "\" />";
  }
?>