<?php
  require "dbConnect.php";
  $db = get_db();
?>
<form>
  <input type="text" name="book" placeholder="Book" required>
  <input type="text" name="chapter" placeholder="Chapter" required>
  <input type="text" name="verse" placeholder="Verse" required>
  <textarea name="content" placeholder="Content" required></textarea>
  <?php

  ?>
  <button type="submit">Submit</button>
</form>