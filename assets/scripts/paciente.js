

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

    // EVENT LISTENERS

    $("#notificaciones").on("click", () => {
        //TODO: mostrar listado con notificaciones
    })


    $("#cambiarClave").on("click", function () {
        //mostramos un pop-up
        Swal.fire({
            icon: 'info',
            title: 'Cambiar clave',
            text: 'No podrás deshacer esta opción',
            input: 'password',
            inputPlaceholder: 'Introduce tu contraseña',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        }).then(password => {
            //cuando se introduzca una contraseña
            $("#clave").val(password.value);
        })
    });


    //botones de anular cita
    $(".anular-cita-btn").on("click", function () {
        //cogemos el tr, que es la cita que tiene todos los datos
        let cita = $(this).parent().parent();
        let id_cita = $(this).data("id-cita");
        let medico = $(cita).children().eq(0).text();
        let fecha = $(cita).children().eq(1).text();
        let hora = $(cita).children().eq(2).text();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Quieres cancelar la cita con ${medico} el ${fecha} a las ${hora}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro',
            cancelButtonText: "Cancelar"
        }).then((result) => {

            //propia indica al controlador si se quire borrar una cita propia o de otra persona.
            //hay que recordar que el controlador lo usaran varios tipos de usuario.
            $.post(localStorage.getItem("hc_base_url") + "Citas_controller/borrarCita", { cita: id_cita, ajax: true, propia: true }, function (data) {
                //si se ha borrado correctamente
                if (data == 1) {
                    $(cita).fadeOut(500);
                    Swal.fire(
                        'Cita borrada correctamente',
                        `Acabas de anular la cita con ${medico}`,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        `Ha ocurrido un error al borrar la cita. Inténtalo en unos minutos.`,
                        'error'
                    );
                }
            });
        })
    });

    //boton de logout
    $("#logout").on("click", () => {
        //si hace clic en el boton de logout, redirigimos al login
        window.location = localStorage.getItem("hc_base_url") + "login";
    });

});
