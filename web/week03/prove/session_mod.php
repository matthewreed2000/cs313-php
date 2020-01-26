<?php
  session_start();

  function is_items_set() {
    if (isset($_GET)) {
      if (isset($_GET['items']) && isset($_GET['mod_type'])) {
        return true;
      }
    }
    return false;
  }

  function rem_item($key) {
    if (isset($_SESSION['items'][$key])) {
      unset($_SESSION['items'][$key]);
    }
  }

  function set_item($key, $value) {
    $item_num = $value;

    if (!is_numeric($item_num))
    {
      unset($item_num);
    }
    else if ($item_num <= 0) {
      rem_item($key);
    }
    else {
      $_SESSION['items'][$key] = $item_num;
    }

    echo $_SESSION['items'][$key];
  }

  function inc_item($key, $value) {
    $item_num = $value;

    if (!is_numeric($item_num)) {
      $item_num = $_SESSION['items'][$key];
    }
    else {
      $item_num += $_SESSION['items'][$key];
    }

    set_item($key, $item_num);
  }

  function dec_item($key, $value) {
    $item_num = $value;

    if (!is_numeric($item_num)) {
      $item_num = $_SESSION['items'][$key];
    }
    else {
      $item_num = $_SESSION['items'][$key] - $item_num;
      if ($item_num <= 0) {
        $item_num = 0;
      }
    }

    set_item($key, $item_num);
  }

  if (is_items_set()) {
    foreach ($_GET['items'] as $key => $value) {
      if ($key == htmlspecialchars($key)) {
        if ($_GET['mod_type'] == 'rem') {
          rem_item($key);
        }
        else if ($_GET['mod_type'] == 'set'){
          set_item($key, $value);
        }
        else if ($_GET['mod_type'] == 'dec') {
          dec_item($key, $value);
        }
        else if ($_GET['mod_type'] == 'inc') {
          inc_item($key, $value);
        }
      }
    }
  }
?>

<html>
  <head>
    <title>GET OUT OF MY SWAMP!</title>
  </head>
  <body>
    <p>Umm...You're not supposed to be here</p>
    <?php
      print_r($_SESSION);
    ?>
  </body>
</html>