$(document).ready(function () {
  var host = hostWS;
  var socket = new WebSocket(host);
  socket.onmessage = function(e) {
      document.getElementById('nOrders').innerHTML = e.data;
  };
  $("#socketOn").on("click",function(){
    $.ajax({
      url: urlsw,
      type: "GET",
      dataType: "json",
      ContentType: "application/json",
      success: function (data) {
        alert("Se hizo la compra")
        console.log(data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.warn(textStatus);
      }
    });
  })
});