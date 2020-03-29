//este archivo se cargará en gran parte de la aplicacion ya que es ampliamente usado
$(document).ready(function () {
    // ===== RELOJ =====
    let dias = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sabado");
    let meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    function actualizarFecha() {
        let d = new Date();
        let cadena = "Hoy es ";
        cadena += dias[d.getUTCDay()] + " ";
        cadena += d.getUTCDate() + " de ";

        cadena += meses[d.getUTCMonth()] + " de ";
        cadena += d.getUTCFullYear();

        cadena += " | ";

        cadena += d.getHours() + ":";

        //si los minutos son de 0 a 9
        if (d.getMinutes().toString().length == 1) {
            //añade un 0 delante
            cadena += "0" + d.getMinutes();
        } else {
            //de lo contrario pone la fecha
            cadena += d.getMinutes();
        }
        $("#reloj").text(cadena);
    }

    //ejecutamos la funcion de la fecha una vez
    actualizarFecha();

    //intervalo de ejecucion del reloj, cada minuto
    setInterval(actualizarFecha, 60000);

    //===== MENU LATERAL =====
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
    $("#notificaciones-text").on("click", function () {
        //cargamos las notificaciones que tenga el paciente 
        $.post(localStorage.getItem("hc_base_url") + "usuarios_controller/leerNotificaciones", {}, function (data) {
            
            data = JSON.parse(data);

            //borramos todas las notificaciones existentex
            $("#listaNotificaciones").html("");

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
                            'confirmButtonText': "Cerrar",
                            'icon': 'warning',
                            'title': `${notificacion.resumen}`,
                            'text': `${notificacion.informacion}`,
                            'onClose': (event) => {
                                //cuando cierra la notificacion es que ya la ha leido
                                //mandamos borrarla de la bbdd

                                $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/borrarNotificacion", { id: notificacion.id }, (data) => {

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