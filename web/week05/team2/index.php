<?php 
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  $statement = $db->prepare("SELECT name, image FROM w5_EVENT");
  $statement->execute();

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>
    <p><?=$row['name']?></p>
    <img src="<?=$row['image']?>" />
<?php
  }
?>