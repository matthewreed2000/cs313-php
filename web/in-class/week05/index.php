<?php
  require "dbconnect.php";
  $db = get_db();

  $family_members = $db.prepare('SELECT * FROM week05family;');
  $family_members->execute();

  while ($fRow = $family_members->fetch(PDO::FETCH_ASSOC)) {
    
  }
?>