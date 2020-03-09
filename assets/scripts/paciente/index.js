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


    //event listener de las notificaciones
    $("#notificaciones-text").on("click", function() {
        //cargamos las notificaciones que tenga el paciente 
    $.post(localStorage.getItem("hc_base_url") + "paciente/leerNotificaciones", {}, function (data) {
        data = JSON.parse(data);
        
        //borramos todas las notificaciones existentex
        $("#listaNotificaciones").html("");

        for (let notificacion of data) {
            console.log(notificacion);
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
                        'confirmButtonText': "Cerrar",
                        'icon': 'warning',
                        'title': `${notificacion.resumen}`,
                        'text': `${notificacion.informacion}`,
                        'onClose': (event) => {
                            //cuando cierra la notificacion es que ya la ha leido
                            //mandamos borrarla de la bbdd

                            $.post(localStorage.getItem("hc_base_url") + "paciente/borrarNotificacion", { id: notificacion.id }, (data) => {

                                //reducimos la cantidad de notificaciones en uno en el localstorage
                                localStorage.setItem("notificaciones", parseInt(localStorage.getItem("notificaciones")) - 1);

                                //cuando se haya completado, actualizamos los contadores
                                $("#notificaciones").text(localStorage.getItem("notificaciones"));

                                $("#card-notificaciones").text(localStorage.getItem("notificaciones"));



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

    
});


