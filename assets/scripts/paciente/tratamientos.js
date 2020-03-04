$(document).ready(function () {
    //mostramos la cantidad de notificaciones
    $("#notificaciones").text(localStorage.getItem("notificaciones"));

    $.post(localStorage.getItem("hc_base_url") + "Tratamientos_controller/leerTratamientos", {}, function(data) {
        data = JSON.parse(data);

        //si no hay datos, no ejecutamos nada
        if(data.length == 0) return;
        
             
    })
});