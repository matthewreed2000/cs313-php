<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <style type="text/css">
    body {
      text-align: center;
    }
    div {
      border-width: 1px;
      border-color: black;
    }
    .colored {
      color: red;
    }
  </style>
</head>
<body>
  <h1>PHP Team Activity</h1>
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