

$(document).ready(function () {
    let dias = new Array("lunes", "martes", "miércoles", "jueves", "viernes", "sabado", "domingo");
    let meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    function actualizarFecha() {
        let d = new Date();
        let cadena = "Hoy es ";
        cadena += dias[d.getUTCDay() - 1] + " ";
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
    $(".anular-cita").on("click", function () {
        //cogemos el tr, que es la cita que tiene todos los datos
        let cita = $(this).parent().parent();

        let medico = $(cita).children().eq(0).text();
        let fecha = $(cita).children().eq(1).text();
        let hora = $(cita).children().eq(2).text();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Quieres cancelar la cita con ${medico} el ${fecha} a las ${hora}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            

        })
    });

    //boton de logout
    $("#logout").on("click", () => {
        //si hace clic en el boton de logout, redirigimos al login
        window.location =  localStorage.getItem("hc_base_url") + "login";
    });

});
