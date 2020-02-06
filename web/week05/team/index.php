<?php
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

   require "../../modules/dbConnect.php";
   $db = get_db();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Scripture List</title>
</head>
<body>

   <h1>Scripture Resources</h1>

   <?php

      $statement = $db->prepare("SELECT * FROM scripture");
      $statement->execute();

      while ($row = $statement->fetch(PDO::FETCH_ASSOC))
      {
         $book = $row["book"];
         $chapter = $row["chapter"];
         $verse = $row["verse"];
         $content = $row["content"];

         echo "<p><strong>$book $chapter:$verse</strong> - \"$content\"</p>";
      }

   ?>
   <form onsubmit="return requestBook(this);">
   Choose a Book: <input type="text" name="book"><br>
   <input type="submit">
   </form>
   <div id="content"></div>
   <script>
      function requestBook(form) {
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               content = document.getElementById('content');
               console.log(this.responseText);
               var obj = JSON.parse(this.responseText);
               content.innerHTML = '';
               obj.foreach(element => {
                  content.innerHTML += "<p><strong>" + obj.book + ' '
                                    + obj.chapter + ':' + obj.verse
                                    + "</strong> - \"$content\"</p>";
               });
            }
         };
         xhttp.open('POST', 'getBooks.php', true);
         data = new FormData(form);
         xhttp.send(data);

         return false;
      }
   </script>
</body>
</html>