$(document).ready(() => {
   $("#buscarUsuario").click(() => {
      let usuario = $("#usuario").val().trim();

      //si no hay usuario cancelamos
      if (!usuario) return;

      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: usuario }, (data) => {
         data = JSON.parse(data);

         if (data.length >= 1) {
            Swal.fire({
               icon: 'question',
               title: 'Confirmación',
               text: `¿Quieres solicitar el traslado a tu centro de ${data[0].nombre_completo}?`,
               showCancelButton: true,
               cancelButtonText: "No",
               confirmButtonText: "Si"
            }).then((e) => {
               //si no le da a 'si', cancelamos
               if (!e.value) return;

               $.post(localStorage.getItem("hc_base_url") + "Gerente_controller/solicitarTraslado", { facultativo: usuario }, (respuesta) => {
                  console.log(respuesta);
                  if (respuesta == 1) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Hecho',
                        text: `Se ha solicitado el traslado de ${data[0].nombre_completo}`,
                     });
                  } else if (respuesta == 0) {
                     Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `El usuario ${data[0].nombre_completo} ya trabaja en tu centro`,
                     });
                  } else if (respuesta == 2) {
                     Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `El usuario ${data[0].nombre_completo} ya está siendo trasladado por otro centro`,
                     });
                  }
               })
            });
         } else {
            Swal.fire({
               icon: 'error',
               title: 'Error',
               text: `No existe ningún usuario con el CIU ${usuario}?`,
            })
         }
      })

   })
})