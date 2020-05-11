$(document).ready(() => {
   //buscador de facultativo
   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#facultativo").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#facultativos").html("");

      //si el input esta vacio, no busca nada
      if ($("#facultativo").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/buscarFacultativoCiuNombre", { dato: $("#facultativo").val() }, (data) => {
            data = JSON.parse(data);
            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#facultativos").append($(option));
            }
         });
      }, 700);
   });

   $("#facultativo").change(function () {
      //cargamos las horas de apertura del centro donde trabaja ese facultativo y las ponemos en el formulario
      $.post(localStorage.getItem("hc_base_url") + "Centros_controller/leerHorasPorFacultativo", { ciu: $(this).val() }, (data) => {
         data = JSON.parse(data);

         //si no hay registros cancelamos
         if (data.length >= 1) {
            //deshabilitamos el campo de busqueda de medicosssssssssssssssssssssssss
            $(this).attr("disabled", "");
         } else {
            return;
         }

         //añadimos la hora y los minutos
         for (let i = data[0].hora_apertura; i <= data[0].hora_cierre - 1; i++) {
            $("#hora").append($(`<option value='${i}'>${i}</option>`));
         }

         for (let i = 0; i <= 55; i += 5) {
            $("#minuto").append($(`<option value='${i}'>${i}</option>`));
         }

         $("#hora").removeAttr("disabled");
         $("#minuto").removeAttr("disabled");
         $("#fecha").removeAttr("disabled");
      });
   });

   $("#paciente").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#pacientes").html("");

      //si el input esta vacio, no busca nada
      if ($("#paciente").val().trim() == "") return;

      interval = setTimeout(function () {

         $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/buscarPacienteCiuNombre", { dato: $("#paciente").val() }, (data) => {
            data = JSON.parse(data);

            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#pacientes").append($(option));
            }
         });
      }, 700);
   });

   $("#paciente").change(function () {
      //cargamos el ciu del medico y enfermero de referencia
      $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/leerFacultativosReferencia", { ciu: $(this).val() }, (data) => {
         data = JSON.parse(data);

         //deshabilitamos el campo de busqueda de paciente
         if (data.length >= 1) $(this).attr("disabled", "");

         Swal.fire({
            icon: 'info',
            title: 'Información del paciente',
            html: `
               <p>Nombre del médico: ${data.nombre_medico}</p>
               <p>CIU del médico: ${data.ciu_medico}</p>
               <p>Nombre del enfermero: ${data.nombre_enfermero}</p>
               <p>CIU del enfermero: ${data.ciu_enfermero}</p>            
            `,
         })
      })
   });

   $("#buscar").click(() => {
      $(".buscador").fadeOut(300);

      //cogemos todos los datos del formulario
      //todos tendrán un valor por defecto, por lo que no hace falta comprobar su valor
      let medico = $("#facultativo").val();
      let paciente = $("#paciente").val();
      let fecha = $("#fecha").val();
      let hora = $("#hora").val();
      let minuto = $("#minuto").val();


      //mostramos una ventana de espera
      Swal.fire({
         title: 'Buscando cita',
         html: 'Buscando una cita lo más cerca posible a los datos solicitados',
         onBeforeOpen: () => {
            //hacemos que se muestre el icono de carga
            Swal.showLoading();
         }
      });


      //hacemos la peticion ajax al servidor con los datos solicitados
      $.post(localStorage.getItem("hc_base_url") + "Citas_controller/buscarLibres", { medico: medico, fecha: fecha, hora: hora, minuto: minuto }, function (data) {
         //cerramos la ventana de espera
         Swal.close();

         //parseamos a JSON
         data = JSON.parse(data);

         $("#mostrarListaCitas").click();
         let tabla_citas = $("#horas");

         for (let hora of data) {
            let fila = document.createElement("TR");
            let fecha = document.createElement("TD");
            let horaCita = document.createElement("TD");

            //=== APARTADO PARA EL BOTON DE SOLICITAR CITA ===
            let accion = document.createElement("TD");

            let btn = document.createElement("BUTTON");
            btn.classList.add("btn");
            btn.classList.add("btn-success");
            btn.classList.add("citas-btn-solicitar-cita");

            btn.dataset.info_cita = hora;

            btn.innerText = "Solicitar Cita";
            accion.appendChild(btn);


            btn.addEventListener("click", function () {
               $.post(localStorage.getItem("hc_base_url") + "Citas_controller/seleccionarCita", { info: this.dataset.info_cita, medico: medico, paciente: paciente }, function (data) {
                  console.log(data);
                  if (data == 1) {
                     $("#citas-cerrar-buscador").click();
                     Swal.fire({
                        title: 'Cita reservada',
                        text: 'Se ha confirmado la cita',
                        icon: 'success',
                        onClose: function () { window.location.reload(); }
                     })
                  }
               });
            });
            //================================================

            fecha.innerText = hora[1];
            horaCita.innerText = hora[0];


            fila.appendChild(fecha);
            fila.appendChild(horaCita);
            fila.appendChild(accion);

            document.getElementById("horas").appendChild(fila);
         }
      });

      $(".horas").delay(100).fadeIn(300);
   })

   $("#hora").change(comprobarCampos);
   $("#minuto").change(comprobarCampos);
   $("#fecha").change(comprobarCampos);
});


function comprobarCampos() {
   //funcion que comprueba todos los campos antes de habilitar el boton de busqueda
   let paciente = $("#paciente").val();
   let facultativo = $("#facultativo").val();
   let hora = $("#hora").val();
   let minuto = $("#minuto").val();
   let fecha = $("#fecha").val();

   if (paciente && facultativo && hora && minuto && fecha) {
      $("#buscar").removeAttr("disabled");
   }
}
