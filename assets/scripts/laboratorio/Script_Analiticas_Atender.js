$(document).ready(() => {
   $("#buscar").click(() => {
      let codigo = $("#codigo").val().trim();

      if (codigo == "") return;

      $.post(localStorage.getItem("hc_base_url") + "API/Analiticas/buscarAnalitica", { id: codigo }, (data) => {
         data = JSON.parse(data);
         
         if (data[0].existe == 0) {
            Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'No existe ninguna analítica con ese identificador'
            })
         } else {
            Swal.fire({
               icon: 'question',
               title: 'Confirmación',
               text: `¿Quieres atender la analítica con ID ${codigo}?`,
               confirmButtonText: 'Si',
               showCancelButton: true,
               cancelButtonText: 'No'
            }).then(e => {
               //si pulsa cancelar
               if (!e.value) return;

               $.post(localStorage.getItem("hc_base_url") + "API/Analiticas/atenderAnalitica", { id: codigo }, (respuesta) => {
                  if (respuesta == 1) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Hecho',
                        html: 'Se te ha asignado esta analítica. Puedes rellenarla en el apartado de <i>Analíticas atendidas</i>'
                     });
                  } else {
                     Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'No se ha encontrado una analítica con esa ID o ya ha sido atendida'
                     });
                  }
               });
            })
         }
      })
   })
})