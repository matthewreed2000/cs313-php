<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <style type="text/css">
    .colored {
      color: red;
    }
  </style>
</head>
<body>
  <?php
    for ($i = 0; $i < 10; $i++) {
      echo '<div';
      if ($i % 2 == 0) {
        echo " class=\"colored\"";
      }
      echo "><p>This is div #$i</p></div>";
    }
  ?>
</body>
</html>