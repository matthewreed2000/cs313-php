<?php
  session_start();

  // Read in CSV file that contains info about items that are being carried
  $csv = array_map("str_getcsv", file("stock.csv", FILE_SKIP_EMPTY_LINES));
  $keys = array_shift($csv);
  $stock = array();

  foreach ($csv as $i=>$row) {
    $stock[$row[0]] = array_combine($keys, $row);
  }

  unset($keys);
  unset($csv);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Browse</title>
  <link rel="stylesheet" href="../../css/main.css">
  <link rel="stylesheet" href="css/store.css">
</head>
<body>
  <div id="page-container">
    <?php include "modules/header.html"?>
    <main id="content-wrap">
      <div class="product-list">
      <?php foreach ($stock as $item) { ?>
        <div class="product">
          <img src="<?=$item['img']?>" alt="<?=$item['display']?>" />
          <p><?=$item['display']?></p>
          <p><?=$item['price']?></p>
          <div class="input-area">
            <button type="button" onClick="decreaseOrder('<?=$item['id']?>');">-</button>
            <input id="<?=$item['id']?>Input" type="text" value="1" oninput="validateValue(this);"/>
            <button type="button" onClick="increaseOrder('<?=$item['id']?>');">+</button>
            <button type="button" class="add-cart" onclick="addToCart('<?=$item['id']?>', this);">ADD TO CART</button>
          </div>
        </div>
      <?php } ?>
      </div>
    </main>
    <?php include "../../modules/footer.html"?>
  </div>
  <script src="js/browse.js"></script>
</body>
</html>