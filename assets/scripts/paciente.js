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

    $("#notificaciones").on("click", () => {
        //TODO: mostrar listado con notificaciones
    })

    
    //para cada elemento del menu
    for (let a of document.getElementsByClassName("list-group")[0].children) {

        //si el href coincide con la url actual
        if (a.href == window.location.href) {

            //añade la clase active para que resalte en azul
            a.children[0].classList.add("active");
        }
    }
});