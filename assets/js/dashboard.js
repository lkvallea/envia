$(document).ready(function () {
    var host = hostWS;
    var socket = new WebSocket(host);
    socket.onmessage = function(e) {
        document.getElementById('nOrders').innerHTML = e.data;
    };
  });