$(document).ready(function () {

 
  $("#nameHeading").on("click", function () {
    $(".myName")
      .text("Jack Sampson")
      .css({
        "font-variant": "small-caps",
        "color": "#d4380d",
        "font-size": "200%"
      });
  });


  $("#hideText").on("click", function (e) {
    e.preventDefault();
    $("#textContent p").hide(2000);
  });
  $("#showText").on("click", function (e) {
    e.preventDefault();
    $("#textContent p").show(3300);
  });
  $("#toggleText").on("click", function (e) {
    e.preventDefault();
    $("#textContent p").toggle(1500);
  });


  let itemCount = 5;
  $("#AddListItem").on("click", function () {
    itemCount++;
    const newItem = `<li>New item ${itemCount} - Click me!</li>`;
    $("#labList").append(newItem);
  });


  $(document).on("click", "#labList li", function () {
    $(this).toggleClass("red");
  });

});