<?php
  session_start();

  // Define functions
  function sanitize_input($value, $format) {
    return $value;
  }

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

  // Get address and sanitize it
  $keys = array('addr1' => 'str', 'addr2' => 'str', 'city' => 'str', 'state' => '2ch', 'zip' => 'num');
  $addr = array();

  foreach ($keys as $key=>$format) {
    if (isset($_POST[$key])) {
      $addr[$key] = sanitize_input($_POST[$key], $format);
    }
    else {
      $addr[$key] = '';
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Checkout</title>
  <link rel="stylesheet" href="../../css/main.css">
  <link rel="stylesheet" href="css/store.css">
</head>
<body>
  <div id="page-container">
    <?php include "modules/header.html"?>
    <main id="content-wrap">
      <div id="receipt">
        <?php
          $total = 0;
          foreach ($items as $key=>$value) {
            if (isset($stock[$key])) {
              $item = $stock[$key];
              $total += str_replace('$', '', $item['price']) * $value;
        ?>
          <p><?=$item['display']?> x <?=$value?></p><br>
        <?php }} ?>
        <hr />
        <p>Total Price: $<?=number_format((float)$total, 2)?></p>
        <hr />
        <div>
          <p><?=$addr['addr1']?> <?=$addr['addr2']?></p>
          <p><?=$addr['city']?>, <?=$addr['state']?></p>
          <p><?=$addr['zip']?></p>
        </div>
      </div>
    </main>
  </div>
  <script src="js/cart.js"></script>
</body>
</html>