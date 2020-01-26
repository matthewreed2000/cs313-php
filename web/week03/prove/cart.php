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

  // Get items and item amounts currently in the session
  $items = array();

  if (isset($_SESSION['items'])) {
    foreach ($_SESSION['items'] as $key => $value) {
      if (isset($stock[$key]))
      {
        $items[$key] = $value;
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cart</title>
  <link rel="stylesheet" href="../../css/main.css">
  <link rel="stylesheet" href="css/store.css">
</head>
<body>
  <div id="page-container">
    <?php include "modules/header.html"?>
    <main id="content-wrap">
      <div class="product-list">
      <?php
        foreach ($items as $key=>$value) {
          if (isset($stock[$key])) {
            $item = $stock[$key];
      ?>
        <div class="product">
          <img src="<?=$item['img']?>" alt="<?=$item['display']?>" />
          <p><?=$item['display']?></p>
          <p class="itemPrice"><?=$item['price']?></p>
          <div class="input-area">
            <button type="button" onClick="decreaseOrder('<?=$item['id']?>', this.parentNode.parentNode);">-</button>
            <input id="<?=$item['id']?>Input" type="text" value="<?=$value?>" oninput="validateValue(this);"/>
            <button type="button" onClick="increaseOrder('<?=$item['id']?>');">+</button>
            <button type="button" class="add-cart" onclick="removeItem('<?=$item['id']?>', this.parentNode.parentNode);">REMOVE ITEM</button>
          </div>
        </div>
      <?php }} ?>
      </div>
      <div class="jumbotron">
        <h2>Price = $<span id="totalPrice">0</span></h2>
        <a href="checkout.php"><button type="button">Proceed to Checkout</button></a>
      </div>
    </main>
    <?php include "../../modules/footer.html"?>
  </div>
  <script src="js/cart.js"></script>
</body>
</html>