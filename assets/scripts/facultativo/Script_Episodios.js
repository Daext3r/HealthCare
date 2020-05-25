$(document).ready(() => {
   //leemos los episodios del paciente seleccionado, si es que hay
   let paciente = JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(p => p.seleccionado == true)[0];

   if (paciente) leerEpisodiosPaciente(paciente.CIU);


   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#especialidad").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#especialidades").html("");

      //si el input esta vacio, no busca nada
      if ($("#especialidad").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/buscarEspecialidad", { especialidad: $("#especialidad").val() }, (data) => {
            data = JSON.parse(data);
            for (let especialidad of data) {
               let option = document.createElement("option");
               option.value = especialidad.id;
               option.innerText = especialidad.denominacion;
               $("#especialidades").append($(option));
            }
         });
      }, 700);
   });

   $("#crearEpisodio").click(() => {
      let paciente = $(".seleccionado")[0];
      let especialidad = $("#especialidad").val().trim();
      let descripcion = $("#descripcion").val().trim();

      //si no hay descripcion y especialidad cancelamos
      if (descripcion == "" || especialidad == "") {
         Swal.fire(
            'Error',
            'Rellena los datos necesarios para crear el episodio',
            'error'
         );

         return;
      }

      //si no hay un paciente seleccionado cancelamos y mostramos error
      if (paciente == undefined) {
         $("#modal-nuevo-episodio").modal('toggle');
         Swal.fire(
            'Error',
            'Selecciona un paciente antes de crear un episodio',
            'error'
         );
         return;
      }

      $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/crearEpisodio", {
         descripcion: descripcion,
         especialidad: especialidad,
         paciente: paciente.dataset.CIU
      }, (data) => {
         if (data == 1) {
            //cerramos el modal y mostramos mensaje de exito
            $("#modal-nuevo-episodio").modal('toggle');

            Swal.fire(
               'Hecho',
               'Episodio creado con éxito',
               'success'
            );
         }
      });
   });

   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => {
      //borramos los episodios previos
      $("#episodios").html("");

      leerEpisodiosPaciente(e.detail.CIU);
   })

});

function leerEpisodiosPaciente(ciu) {
   $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/leerEpisodios", { ciu: ciu }, (data) => {
      data = JSON.parse(data);
      console.log(data);

      for (let episodio of data) {
         let div = $(`
            <div class="alert alert-secondary w-75" data-id="${episodio.id}">
            <div>Especialidad: <i>${episodio.especialidad}</i></div>
               <div>
                  <span>Descripción: <i>${episodio.descripcion}</i></span> | <span><a href="${localStorage.getItem("hc_base_url")}facultativo/informes/historial?episodio=${episodio.id}"}">Ver Informes de este episodio</a></span>
               </div>
               <div>
                  <span>Creación: <i>${episodio.fecha_creacion}</i></span> | <span>Últ. Actualización: <i>${episodio.ult_actualizacion}</i></span>
               </div>
               <div>
                  ID: <i>${episodio.id}</i> | Cerrado: <i>${episodio.cerrado == 1 ? "Si" : "No"}</i>
               </div>
            </div>
         `);

         $("#episodios").append($(div));
      }
   });
}