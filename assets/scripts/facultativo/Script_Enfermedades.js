var listaEnfermedades = [];

$(document).ready(() => {
   leerEnfermedades($("div.paciente.seleccionado")[0].dataset.CIU);

   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => leerEnfermedades(e.detail.CIU));

   $("#nuevaEnfermedad").click(() => {
      Swal.fire({
         icon: 'question',
         text: 'Nombre de la enfermedad',
         input: 'text'

      }).then((e) => {
         //si no hay valor cancelamos
         if(!e.value) return;

         //si la enfermedad ya esta en la lista cancelamos
         if(listaEnfermedades.indexOf(e.value) != -1) {
            Swal.fire('Error', 'Ya hay una enfermedad con ese nombre añadida', 'error');
            return;
         }
         listaEnfermedades.push(e.value);
         generarEnfermedad(e.value);
         actualizarDatos();
      });
   });
});

function leerEnfermedades(paciente) {
   //borramos las enfermedades que haya
   $(".listaEnfermedades")[0].innerHTML = "";
   listaEnfermedades = [];

   $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/leerEnfermedadesPaciente", { paciente: paciente }, (data) => {
      try {
         data = JSON.parse(data);
      } catch(e) {
         return;
      }
      
      //si no hay enfermedades cancelamos
      if (data == null) return;

      //para cada enfermedad
      for (let enfermedad of data) {
         listaEnfermedades.push(enfermedad);
         generarEnfermedad(enfermedad);
      }
   });
}

function generarEnfermedad(enf) {
   let enfermedad = $(`
         <div class="enfermedad row alert alert-secondary">
            <div class="col d-flex align-items-center">
               ${enf}
            </div>
            <div class="col-1">
               <button class="btn btn-danger" onclick="borrarEnfermedad('${enf}')"><i class="fas fa-trash"></i></button>
            </div>
         </div>
   `);

   $(".listaEnfermedades").append($(enfermedad));
}

function actualizarDatos() {
   $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/actualizarEnfermedadesPaciente", { paciente: $("div.paciente.seleccionado")[0].dataset.CIU, enfermedades: JSON.stringify(listaEnfermedades) }, (data) => {
      if (data == 1) {
         Swal.fire({
            icon: 'success',
            title: 'Hecho',
            text: 'Se han actualizado los datos'
         })
      }
   });
}

function borrarEnfermedad(enf) {
   //borramos la enfermedad del array
   let nuevoarray = []

   for (let enfermedad of listaEnfermedades) {
      if (enfermedad != enf) nuevoarray.push(enfermedad);
   }

   listaEnfermedades = null;
   listaEnfermedades = nuevoarray;

   //borramos la enfermedad de la pantalla
   for (let div of $(".enfermedad")) {
      if (div.children[0].innerText == enf) div.remove();
   }

   actualizarDatos();
}