//cuando el documento se haya cargado
$(document).ready(function () {
    //llamamos 
    $('#botonera').pagination({
        dataSource: function (done) {
            //cuando se complete la solicitud llamamos a done como callback
            $.post(localStorage.getItem("hc_base_url") + "Informes_controller/leerListaInformes", { ajax: true, propio: true }, function (data) {
                done(JSON.parse(data));
            });
        },
        pageSize: 1,
        showPageNumbers: false,
        showNavigator: true,
        showPrevious: true,
        showNext: true,
        formatNavigator : " Página <%= currentPage %> de <%= totalPage %>",
        
        callback: (data, pagination) => {
            //data son los datos a mostrar en esta página
            //eliminamos el contenido de la lista
            $("#lista").html("");
            //para cada informe
            for(let informe of data) {
                let elemento = document.createElement("li");

                let enlace = document.createElement("a");
                enlace.href = localStorage.getItem("hc_base_url") + `Informes_controller/verInforme/${informe.id}`;
                enlace.innerText = "Ir al informe";

                let especialidad = document.createElement("p");
                especialidad.innerText = `Informe de ${informe.especialidad}`;

                let fecha = document.createElement("small");
                fecha.innerText = `Fecha: ${new Date(informe.fecha).toLocaleDateString()}`

                let medico = document.createElement("p");
                medico.innerText = `Facultativo: ${informe.nombre_completo_medico}`;
                
                elemento.appendChild(especialidad);
                elemento.appendChild(enlace);
                elemento.appendChild(fecha);
                elemento.appendChild(medico);

                $(elemento).appendTo($("#lista"));

            }
        }
    })
});