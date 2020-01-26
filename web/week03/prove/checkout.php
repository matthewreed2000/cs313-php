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
      </div>
      <form action="confirm.php" method="POST">
        <input type="text" name="addr1" placeholder="Street Address" required />
        <input type="text" name="addr2" placeholder="Apt#, Building, etc." />
        <input type="text" name="city" placeholder="City" required />
        <select name="state" required>
          <option value="" selected disabled hidden>State</option>
          <?php
            $states = array('Alabama' => 'AL', 'Alaska' => 'AK', 'Arizona' => 'AZ', 'Arkansas' => 'AR',
              'California' => 'CA', 'Colorado' => 'CO', 'Connecticut' => 'CT', 'Delaware' => 'DE',
              'Florida' => 'FL', 'Georgia' => 'GA', 'Hawaii' => 'HI', 'Idaho' => 'ID', 'Illinois' => 'IL',
              'Indiana' => 'IN', 'Iowa' => 'IA', 'Kansas' => 'KS', 'Kentucky' => 'KY', 'Louisiana' => 'LA',
              'Maine' => 'ME', 'Maryland' => 'MD', 'Massachusetts' => 'MA', 'Michigan' => 'MI',
              'Minnesota' => 'MN', 'Mississippi' => 'MS', 'Missouri' => 'MO', 'Montana' => 'MT',
              'Nebraska' => 'NE', 'Nevada' => 'NV', 'New Hampshire' => 'NH', 'New Jersey' => 'NJ',
              'New Mexico' => 'NM', 'New York' => 'NY', 'North Carolina' => 'NC', 'North Dakota' => 'ND',
              'Ohio' => 'OH', 'Oklahoma' => 'OK', 'Oregon' => 'OR', 'Pennsylvania' => 'PA',
              'Rhode Island' => 'RI', 'South Carolina' => 'SC', 'South Dakota' => 'SD', 'Tennessee' => 'TN',
              'Texas' => 'TX', 'Utah' => 'UT', 'Vermont' => 'VT', 'Virginia' => 'VA', 'Washington' => 'WA',
              'West Virginia' => 'WV', 'Wisconsin' => 'WI', 'Wyoming' => 'WY');
            foreach ($states as $long=>$short) {
          ?>
            <option value="<?=$short?>"><?=$long?></option>
          <?php } ?>
        </select>
        <input type="text" name="zip" placeholder="Zip Code" required />
        <a href="cart.php"><button type="button">Return to Cart</button></a>
        <button type="submit">Proceed</button>
      </form>
    </main>
  </div>
  <script src="js/cart.js"></script>
</body>
</html>