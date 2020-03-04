$(document).ready(function () {
    //mostramos la cantidad de notificaciones
    $("#notificaciones").text(localStorage.getItem("notificaciones"));
});