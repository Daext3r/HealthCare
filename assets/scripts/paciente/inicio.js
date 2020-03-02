$(document).ready(function () {
    //si estamos en la pagina de inicio
    if (window.location.href == localStorage.getItem("hc_base_url") + "paciente/inicio") {
        //guardamos las notificaciones en localstorage, ya que solo se leen aqui
        localStorage.setItem("notificaciones", $("#card-notificaciones").text());

        //mostramos las notificaciones en la barra superior
        $("#notificaciones").text($("#card-notificaciones").text());
    } else {
        //de lo contrario, estaremos en cualquier otra pagina y simplemente lo mostramos
        $("#notificaciones").text(localStorage.getItem("notificaciones"));
    }

});