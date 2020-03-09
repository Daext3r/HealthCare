//script que se cargará en el apartado inicio del paciente

$(document).ready(function () {
    //guardamos las notificaciones en localstorage, ya que solo se leen aqui
    localStorage.setItem("notificaciones", $("#card-notificaciones").text());

    //mostramos las notificaciones en la barra superior
    //por defecto se muestran en la tarjeta inferior
    $("#notificaciones").text($("#card-notificaciones").text());

});