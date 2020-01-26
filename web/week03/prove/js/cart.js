function decreaseOrder(itemID, container) {
  var inputFeild = document.getElementById(itemID + 'Input');
  var value = inputFeild.value;

  // Validate input
  if (isNaN(value)) {
    var newVal = 1;
    inputFeild.value = newVal;
    updateValue(itemID, newVal);
  }
  // Decrease the value
  else if (value > 1) {
    var newVal = Number(value) - 1;
    inputFeild.value = newVal;
    updateValue(itemID, newVal);
  }
  // Remove item
  else if (value <= 1) {
    removeItem(itemID, container);
  }
}

function increaseOrder(itemID) {
  var inputFeild = document.getElementById(itemID + 'Input');
  var value = inputFeild.value;

  // Validate input
  if (isNaN(value)) {
    var newVal = 1;
    inputFeild.value = newVal;
    updateValue(itemID, newVal);
  }
  // Increase the value
  else {
    var newVal = Number(value) + 1;
    inputFeild.value = newVal;
    updateValue(itemID, newVal);
  }
}

function validateValue(inputFeild) {
  // Only allow numbers
  inputFeild.value = inputFeild.value.replace(/^(0*)([^\d]*)/g, '');
}

function removeItem(itemID, container) {
  // Update the session variable
  var url = "session_mod.php?mod_type=rem&items[" + itemID + "]=0";

  var xhttp = new XMLHttpRequest;
  xhttp.open("GET", url, true);
  xhttp.send();

  // Remove the parent's visibility
  container.style.display = "none";

  // Update display price
  document.getElementById(itemID + 'Input').value = 0;
  updatePrice();
}

function updateValue(itemID, value) {
  // Update the session variable
  var url = "session_mod.php?mod_type=set&items[" + itemID + "]=" + value;

  var xhttp = new XMLHttpRequest;
  xhttp.open("GET", url, true);
  xhttp.send();

  // Update display price
  updatePrice();
}

function updatePrice() {
  var priceTxt = document.getElementById('totalPrice');
  var itemPrices = document.getElementsByClassName('itemPrice');

  var total = 0;

  for (var i = 0; i < itemPrices.length; i++) {
    var itemPriceVar = itemPrices.item(i);
    var unitPrice = itemPriceVar.innerHTML.replace('$', '');
    var numUnits = itemPriceVar.parentNode.getElementsByTagName('input')[0].value;

    if (!isNaN(unitPrice) && !isNaN(numUnits)) {
      total += Number(numUnits) * Number(unitPrice);
    }
  }

  priceTxt.innerHTML = total.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function() {
  updatePrice();
});