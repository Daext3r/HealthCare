$(document).ready(() => {
   //cuando se cargue el documento, listamo todos los tratamientos que actualmente tiene el paciente seleccionado
   listarTratamientos($("div.paciente.seleccionado")[0].dataset.CIU);

   //añadimos evento para que cuando cambiemos de paciente cargue los tratamientos del nuevo
   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => { listarTratamientos(e.detail.CIU) });
});

function listarTratamientos(paciente) {
   //quitamos los tratamientos que haya previamente
   $("#tratamientos").html("");

   $.post(localStorage.getItem("hc_base_url") + "API/Tratamientos/leerTratamientosFacultativo", { paciente: paciente }, async (data) => {
      data = JSON.parse(data);

      //por cada tratamiento
      for await (let tratamiento of data) {
         console.log(tratamiento);
         //leemos el nombre del medicamento por la API 
         let datos = await fetch(`https://cima.aemps.es/cima/rest/medicamento?nregistro=${tratamiento.nregistro}`)
            .then((respuesta) => {
               //convertimos la respuesta en un objeto literal json
               return respuesta.json();
            })
            .then((respuesta) => {
               return [respuesta.nombre, respuesta.fotos == undefined ? "" : respuesta.fotos[0].url];
            });

         $("#tratamientos").append($(`
            <div class="alert alert-secondary row w-75">
               <div class="col col-4"><img src="${datos[1] != "" ? datos[1] : localStorage.getItem("hc_base_url") + "assets/img/NoImagenMedicamento.png"}" alt="" style="width: 60%"></div>
               <div class="col col-7">${datos[0]}</div>
               <!--<div class="col col-1">
                  <button class="btn btn-dark"><i class="fas fa-pen"></i></button>
               </div>-->
               <div class="col col-1">
                     <button class="btn btn-danger" onclick="borrarTratamiento(${tratamiento.id})"><i class="fas fa-trash"></i></button>
               </div>
            </div>
            `));
      }
   });
}

function borrarTratamiento(tratamiento) {
   Swal.fire({
      icon: 'question',
      'text': '¿Estás seguro de que quieres borrar este tratamiento?',
      title: 'Borrar tratamiento',
      showCancelButton: true,
      cancelButtonText: "No",
      confirmButtonText: "Si"
   }).then((result) => {
      if (result.value) {
         $.post(localStorage.getItem("hc_base_url") + "API/Tratamientos/borrarTratamiento", { id: tratamiento }, (data) => {
            if (data == 1) {
               Swal.fire(
                  'Hecho',
                  'Se ha borrado el tratamiento',
                  'success'
               ).then(() => window.location.reload());
            }
         });
      }
   })
}