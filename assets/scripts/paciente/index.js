//script que se cargara en todas las paginas del paciente
$(document).ready(function () {
    // MENU LATERAL
    //para cada elemento del menu lateral
    for (let a of document.getElementsByClassName("list-group")[0].children) {

        //si el href coincide con la url actual
        if (a.href == window.location.href) {

            //añade la clase active para que resalte en azul
            a.children[0].classList.add("active");
        }
    }

    //boton de logout
    $("#logout").on("click", () => {
        //si hace clic en el boton de logout, redirigimos al login
        window.location = localStorage.getItem("hc_base_url") + "login";
    });


    //cargamos las notificaciones que tenga el paciente 
    $.post(localStorage.getItem("hc_base_url") + "paciente/leerNotificaciones", {}, function (data) {
        data = JSON.parse(data);

        for (let notificacion of data) {
            //creamos la notificacion con todos los datos correspondientes
            let notif = document.createElement("a");
            notif.innerText = notificacion.resumen;
            notif.href = "";
            notif.dataset.id = notificacion.id;

            $(notif).appendTo($("#listaNotificaciones"));

            //añadimos un event listener al elemento
            $(notif).on("click", function (e) {
                //evitamos que nos redirija 
                e.preventDefault();

                Swal.fire(
                    {
                        'confirmButtonText' : "Cerrar",
                        'icon': 'warning',
                        'title' : `${notificacion.resumen}`,
                        'text' : `${notificacion.informacion}`,
                        'onClose' : (event) => {
                            //cuando cierra la notificacion es que ya la ha leido
                            //mandamos borrarla de la bbdd

                            $.post(localStorage.getItem("hc_base_url") + "paciente/borrarNotificacion", {id:notificacion.id},(data) => {
                                //cuando se haya completado, actualizamos los contadores
                                $("#notificaciones").text(parseInt($("#notificaciones").text())-1);
                                $("#card-notificaciones").text(parseInt($("#card-notificaciones").text())-1);
                               
                                //this es el enlace al que hacemos clic, puesto que despues de el enlace usamos funciones lambda para no generar un nuevo this
                                $(this).remove();
                            });
                        }
                    }
                )
            });

        }
    });
});


