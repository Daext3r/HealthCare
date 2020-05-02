function crearCita(cita) {
   let contenido = $(`
   <tr data-id="${cita.id}">
      <th scope="row">${cita.nombre_paciente}</th>
      <td>${cita.hora}</td>
      <td>${cita.estado == "P" ? "Pendiente" : (cita.estado == "NA" ? "No Asiste" : "Asiste")}</td>
      <td>${estaAtendido(cita.CIU_paciente, cita.nombre_paciente)}</td>
      <td>
         <select class="form-control" onchange="actualizar('${cita.id}', this)">
            <option value="NA" ${cita.estado == "NA" ? "selected" : ""}>No Asiste</option>
            <option value="A" ${cita.estado == "A" ? "selected" : ""}>Asiste</option>
            <option value="P" ${cita.estado == "P" ? "selected" : ""}>Pendiente</option>
         </select>
      </td>
   </tr>`);

   $("#tabla").append($(contenido));
}

function estaAtendido(ciu, nombre) {
   let atendidos = JSON.parse(localStorage.getItem("hc_lista_pacientes"));

   let pacienteAtendido = false;

   //si no hay pacientes ya atendidos, directamente damos la opcion de atender
   if (!atendidos) return `<button class="btn btn-outline-primary" onclick="atender('${ciu}','${nombre}', this)">Atender</button>`;

   //revisamos todos los pacientes atendidos para ver si el paciente desde el que se llama la funcion lo esta
   for (let paciente of atendidos) {
      if (paciente.CIU == ciu) pacienteAtendido = true;
   }

   //si esta atendido desactivamos el boton. si no lo está, damos la opcion a atender
   if (pacienteAtendido) {
      return `<button class="btn btn-outline-primary disabled">Ya atendido</button>`;
   } else {
      return `<button class="btn btn-outline-primary" onclick="atender('${ciu}','${nombre}', this)">Atender</button>`;
   }
}

function actualizar(id, elem) {
   $.post(localStorage.getItem("hc_base_url") + "Citas_controller/actualizarCita", { id: id, estado: elem.value }, (data) => {
      if (data == 1) {
         Swal.fire(
            'Hecho',
            'Se ha actualizado el estado de la cita',
            'success'
         );

         //actualizamos el valor en la tabla
         let estado = "";
         switch (elem.value) {
            case 'P': estado = "Pendiente"; break;
            case 'NA': estado = "No Asiste"; break;
            case 'A': estado = "Asiste"; break;
         }
         elem.parentNode.parentNode.children[2].innerText = estado;
      }
   });

}

//funcion que añade al paciente seleccionado a la variable de pacientes atendidos en localstorage
function atender(ciu, nombre, elem) {
   let atendidos = JSON.parse(localStorage.getItem("hc_lista_pacientes"));
   let paciente = { CIU: ciu, nombre: nombre, seleccionado: false };

   if (atendidos == null) atendidos = [];

   atendidos.push(paciente);
   localStorage.setItem("hc_lista_pacientes", JSON.stringify(atendidos));

   elem.innerHTML = "Ya atendido";
   elem.classList.add("disabled");
}

$(document).ready(() => {

   //recuperamos todas las citas para este médico en el día de hoy
   $.post(localStorage.getItem('hc_base_url') + "Citas_controller/leerCitasFacultativo", {}, (data) => {
      data = JSON.parse(data);

      for (let cita of data) {
         crearCita(cita);
      }
   })
});