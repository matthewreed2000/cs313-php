function decreaseOrder(itemID) {
  var inputFeild = document.getElementById(itemID + 'Input');
  var value = inputFeild.value;

  // Validate input
  if (isNaN(value)) {
    inputFeild.value = 1;
  }
  // Decrease the value
  else if (value > 1) {
    inputFeild.value = Number(value) - 1;
  }
}

function increaseOrder(itemID) {
  var inputFeild = document.getElementById(itemID + 'Input');
  var value = inputFeild.value;

  // Validate input
  if (isNaN(value)) {
    inputFeild.value = 1;
  }
  // Increase the value
  else {
    inputFeild.value = Number(value) + 1;
  }
}

function validateValue(inputFeild) {
  // Only allow numbers
  inputFeild.value = inputFeild.value.replace(/^(0*)([^\d]*)/g, '');
}

function addToCart(itemID, button) {
  var inputFeild = document.getElementById(itemID + 'Input');
  var value = inputFeild.value;

  // Validate the input
  if (isNaN(value)) {
    return;
  }
  else if (Number(value) <= 0) {
    return;
  }

  // Update the session variable
  var url = "session_mod.php?mod_type=inc&items[" + itemID + "]=" + value;

  var xhttp = new XMLHttpRequest;
  xhttp.open("GET", url, true);
  xhttp.send();

  // Change the buttons to be unclickable
  button.innerHTML = "&#x2714; Added to Cart";
  var buttons = button.parentNode.getElementsByTagName('button');
  for (var i = 0; i < buttons.length; i++) {
    buttons.item(i).disabled = true;
    buttons.item(i).style.backgroundColor = "var(--tertiary-bg-color)";
    buttons.item(i).style.color = "var(--tertiary-text-color)";
    buttons.item(i).style.cursor = "auto";
  }
}