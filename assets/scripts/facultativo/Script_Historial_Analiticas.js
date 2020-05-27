

async function leerAnaliticas() {
   console.log("leer");
   //Borramos las analiticas que haya
   $(".analiticas").html("");

   //mostramos la lista de analiticas y ocultamos la de pruebas
   $(".pruebas").fadeOut(200);
   setTimeout(() => { $(".analiticas").fadeIn(200); }, 200);

   //pequeño timeout para que de tiempo a otro script a guardar el paciente seleccionado
   await setTimeout(()=>{},100);

   //buscamos el paciente que este activo
   let paciente = JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(paciente => paciente.seleccionado == true)[0];
   
   //si no hay paciente cancelamos
   if(!paciente) return;

   $.post(localStorage.getItem("hc_base_url") + "API/Facultativos/leerAnaliticasPaciente", { paciente: paciente.CIU }, (data) => {
      data = JSON.parse(data);

      //si no hay analiticas cancelamos
      if (data.length <= 0) return;


      for (let analitica of data) {
         //mostramos una analitica en el documento
         $(".analiticas").append($(`
         <div class="alert alert-secondary row analitica">
            <div class="col">
               Fecha de solicitud: ${analitica.fecha_solicitud} | Fecha de resultado: ${analitica.fecha_resultado != null ? analitica.fecha_resultado : "N/D"} <br>
               Especialidad: ${analitica.especialidad}
            </div>
            <div class="col col-2">
               
               ${analitica.fecha_resultado != null ? "<span class='badge badge-success'>Terminada</span>" : "<span class='badge badge-warning'>No terminada</span>"}
            </div>
            <div class="col col-1">
               <button class="btn btn-outline-primary" onclick="leerDatosAnalitica(${analitica.codigo_analitica})"><i class="fas fa-eye"></i></button>
            </div>
         </div>
         `));
      }
   });
}

function leerDatosAnalitica(codigo) {
   //borramos las pruebas que haya
   $(".pruebas").html("");

   $.post(localStorage.getItem("hc_base_url") + "API/Analiticas/leerPruebasAnalitica", { codigo: codigo }, async (data) => {
      data = JSON.parse(data);

      //ocultamos la lista de analiticas y mostramos la de pruebas 
      $(".analiticas").fadeOut(200);
      setTimeout(() => { $(".pruebas").fadeIn(200); }, 200);

      //para cada prueba
      for await (let prueba of JSON.parse(data.pruebas)) {
         $(".pruebas").append(`
         <div class="row alert alert-secondary prueba">
            <div class="col">[${prueba.grupo}] ${prueba.prueba}</div>
            <div class="col col-4"><input onchange="actualizarPrueba('${prueba.grupo}', '${prueba.prueba}', this.value)" type="text" class="form-control w-100 d-block" value="${prueba.resultado == null ? "" : prueba.resultado}" disabled></div>
         </div>
         `);
      }

      //por ultimo añadimos las observaciones del personal
      $(".pruebas").append(`
         <div class="row alert alert-secondary prueba">
            <b>Observaciones del personal:</b><br>
            ${data.observaciones_personal}
         </div>
      `);
   })
}

$(document).ready(() => {
   document.getElementById("pacientes").addEventListener("cambioPaciente", leerAnaliticas);

   leerAnaliticas();
});