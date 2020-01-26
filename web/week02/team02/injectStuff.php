<h1>PHP Team Activity</h1>
<?php
  for ($i = 0; $i < 10; $i++) {
    echo "<div class=\"special";
    if ($i % 2 == 0) {
      echo ' colored';
    }
    echo "\"><p>This is div #$i</p></div>";
  }
?>