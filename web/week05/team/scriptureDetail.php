<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require "../../modules/dbConnect.php";
  $db = get_db();

  if (isset($_GET['content_id'])) {
    $content_id = $_GET['content_id'];
    preg_replace('[^\d]', '', $content_id);
  }
  else {
    $content_id = "";
  }

  $scriptures = $db->prepare("SELECT * FROM scripture WHERE content_id=$content_id");
  $scriptures->execute();
  
  $scripture = $scriptures->fetch(PDO::FETCH_ASSOC);
  $book = $scripture["book"];
  $chapter = $scripture["chapter"];
  $verse = $scripture["verse"];
  $content_id = $scripture["content_id"];

  $statement = $db->prepare("SELECT * FROM scripture_content WHERE id=$content_id");
  $statement->execute();

  $content = $statement->fetch(PDO::FETCH_ASSOC)["content"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?=$book.' '.$chapter.':'.$verse?> - Scripture Detail</title>
</head>
<body>
   <h1><?=$book.' '.$chapter.':'.$verse?> - Scripture Detail</h1>
   <p>"<?=$content?>"</p>
</body>
</html>