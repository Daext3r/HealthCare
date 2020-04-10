$(document).ready(() => {
   //cuando el documento se haya cargado, leemos las notificaciones
   $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerNotificaciones", {}, (data) => {
      //convertimos a JSON
      data = JSON.parse(data);

      //guardamos en el localstorage la cantidad de notificaciones
      localStorage.setItem("notificaciones", data.length);

      //mostramos la cantidad de notificaciones
      $("#notificaciones").text(localStorage.getItem("notificaciones"));

      for (let notificacion of data) {
         //creamos la notificacion con todos los datos correspondientes
         let notif = document.createElement("a");
         notif.innerText = notificacion.resumen;
         notif.href = "";
         notif.dataset.id = notificacion.id;

         $(notif).appendTo($("#listaNotificaciones"));

         //añadimos un event listener al elemento
         $(notif).on("click", function (e) {
            //evitamos que nos redirija 
            e.preventDefault();

            Swal.fire(
               {
                  'confirmButtonText': "Cerrar",
                  'icon': 'warning',
                  'title': `${notificacion.resumen}`,
                  'text': `${notificacion.informacion}`,
                  'onClose': (event) => {
                     //cuando cierra la notificacion es que ya la ha leido
                     //mandamos borrarla de la bbdd

                     $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/borrarNotificacion", { id: notificacion.id }, (data) => {

                        //reducimos la cantidad de notificaciones en uno en el localstorage
                        localStorage.setItem("notificaciones", parseInt(localStorage.getItem("notificaciones")) - 1);

                        //cuando se haya completado, actualizamos los contadores
                        $("#notificaciones").text(localStorage.getItem("notificaciones"));

                        $("#cantidad-notificaciones").text(localStorage.getItem("notificaciones"));

                        //this es el enlace al que hacemos clic, puesto que despues de el enlace usamos funciones lambda para no generar un nuevo this
                        $(this).remove();
                     });
                  }
               }
            )
         });
      }

   });
})