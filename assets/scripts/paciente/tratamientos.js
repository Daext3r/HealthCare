$(document).ready(function () {
    //mostramos la cantidad de notificaciones
    $("#notificaciones").text(localStorage.getItem("notificaciones"));

    $.post(localStorage.getItem("hc_base_url") + "Tratamientos_controller/leerTratamientos", {}, function (data) {
        data = JSON.parse(data);
        console.log(data);
        //si no hay datos, no ejecutamos nada
        if (data.length == 0) return;

        //borramos el contenido del cuerpo
        $("#tratamientos").html("");


        for (let tratamiento of data) {


            //primero leemos el nombre del medicamento
            fetch(`https://cima.aemps.es/cima/rest/medicamento?nregistro=${tratamiento.nregistro}`)
                .then(function (respuesta) {
                    //convertimos la respuesta en un objeto literal json
                    return respuesta.json();
                })
                .then(function (respuesta) {
                    //creamos un elemento td y lo almacenamos
                    let enlace = document.createElement("a");
                    enlace.innerText = respuesta.nombre;
                    enlace.href = "";

                    let li = document.createElement("li");
                    $(enlace).appendTo(li);
                    $(li).appendTo("#lista");

                    //VENTANA POPUP
                    $(enlace).on("click", function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Tratamiento',
                            html:
                                `Fecha de inicio del tratamiento ${new Date(tratamiento.fecha_inicio).toLocaleDateString()}<br>
                                Fecha de fin del tratamiento ${new Date(tratamiento.fecha_fin).toLocaleDateString()}<br>`,
                                //hacer bucle for para las horas en un ul
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: true,
                            confirmButtonText: "Cerrar",
                            
                            cancelButtonAriaLabel: 'Thumbs down'
                        })
                    })
                });


        }

    })
});