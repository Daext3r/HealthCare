let pruebas = [];
let analiticaSeleccionada;

$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "Laboratorio_controller/leerAnaliticasAtendidas", {}, (data) => {
      data = JSON.parse(data);
      console.log(data);

      for (let analitica of data) {
         let div = $(`
            <div class="row alert alert-secondary w-75">
               <div class="col">
                  Fecha de solicitud: ${analitica.fecha_solicitud} - Código de analítica: ${analitica.codigo_analitica}
               </div>
               <div class="col col-1">
                  <button class="btn btn-secondary" onclick="leerPruebasAnalitica(${analitica.codigo_analitica})"><i class="fas fa-pen"></i></button>
               </div>
               <div class="col col-1">
                  <button class="btn btn-warning" onclick="cerrarAnalitica(${analitica.codigo_analitica})"><i class="fas fa-lock"></i></button>
               </div>
            </div>
         `);
         $(".listaAnaliticas").append($(div));
      }
   });

   $("#guardarCambios").click(() => {
      $.post(localStorage.getItem("hc_base_url") + "Analiticas_controller/actualizarAnalitica", { pruebas: JSON.stringify(pruebas), analitica: analiticaSeleccionada }, (data) => {
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: 'Se han guardado los cambios'
            });
         }
      });
   });
});

function actualizarPrueba(grupo, prueba, valor) {
   for (let pruebaLista of pruebas) {
      if (pruebaLista.grupo == grupo && pruebaLista.prueba == prueba) {
         pruebaLista.resultado = valor;
      }
   }
}

function leerPruebasAnalitica(codigo) {
   //ocultamos la lista de analiticas
   $(".listaAnaliticas").fadeOut(200);
   setTimeout(() => { $(".pruebas").fadeIn(200); }, 200);

   //guardamos la analitica seleccionada
   analiticaSeleccionada = codigo;

   $.post(localStorage.getItem("hc_base_url") + "Analiticas_controller/leerPruebasAnalitica", { codigo: codigo }, (data) => {
      data = JSON.parse(data);
      pruebas = JSON.parse(data.pruebas);

      for (let prueba of pruebas) {
         $(".pruebas").append($(`
            <div class="row alert alert-secondary prueba">
               <div class="col">[${prueba.grupo}] ${prueba.prueba}</div>
               <div class="col col-4"><input onchange="actualizarPrueba('${prueba.grupo}', '${prueba.prueba}', this.value)" type="text" class="form-control w-100 d-block" value="${prueba.resultado == null ? "" : prueba.resultado}" placeholder="Pendiente"></div>
            </div>
         `));
      }
   });
}

function cerrarAnalitica(codigo) {
   Swal.fire({
      icon: 'question',
      title: 'Confirmación',
      text: '¿Quieres cerrar esta analítica? No podrás volver a editar su resultado',
      showCancelButton: true,
      cancelButtonText: "No",
      confirmButtonText: "Si"
   }).then((e) => {
      if (!e.value) return;

      Swal.fire({
         icon: 'question',
         html: '¿Quieres añadir alguna observación? <br><small>(deja en blanco en caso de que no)</small>',
         input: 'text'
      }).then((e) => {
         if (!e.isConfirmed) return;

         $.post(localStorage.getItem("hc_base_url") + "Analiticas_controller/cerrarAnalitica", { codigo: codigo, observacion: e.value }, (data) => {
            if (data == 1) {
               Swal.fire({
                  icon: 'success',
                  title: 'Hecho',
                  text: 'Se ha cerrado la analítica'
               });
            }
         });
      });
   });
}
