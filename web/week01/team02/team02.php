<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <style type="text/css">
    * {
      box-sizing: border-box;
    }
    body {
      text-align: center;
    }
    div .special {
      border-style: solid;
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
  <div style="width:50%; float:left;">
    <?php include "injectStuff.php"; ?>
  </div>
  <div style="width:50%; float:right;">
    <?php include "injectStuff.php"; ?>
  </div>
</body>
</html>