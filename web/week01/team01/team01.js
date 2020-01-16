function buttonClick() {
  alert("Clicked");
}

function changeDiv(colorInput) {
  document.getElementById('custom').style.backgroundColor = colorInput;
}

$(document).ready(function(){
  $("#fade").click(function(){
    $("#div3").fadeToggle("slow");
  });
});

$(document).ready(function(){
  $("#change2").click(function(){
    var new_color = $("#color_div2").val();
    $("#div2").css("background-color", new_color);
  });
});