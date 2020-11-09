function removeNotification(div) {
  var iddata = div.id;
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "notificaciones",
      action: "descartarNotificaciones",
      ajaxenable: "true",
      iddata: iddata
    },
    cache: false
  }).done(function(html) {
    div.remove();
  });
  return false;
}
