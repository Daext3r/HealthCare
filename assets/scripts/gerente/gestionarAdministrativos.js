$(document).ready(() => {
   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#usuario").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#usuarios").html("");

      //si el input esta vacio, no busca nada
      if ($("#usuario").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $("#usuario").val() }, (data) => {
            data = JSON.parse(data);
            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#usuarios").append($(option));
            }
         });
      }, 700);
   });

   //si cambia es que ha seleccionado un usuario
   $("#usuario").change(function () {
      //nombre del usuario
      let nombre;

      //buscamos el nombre del que hemos seleccionado
      for (let hijo of $("#usuarios").children()) {
         if ($(hijo).val() == $(this).val()) {
            nombre = $(hijo).html();
         }
      }

      Swal.fire({
         title: '¿Estás seguro?',
         text: `¿Quieres añadir a ${nombre} como administrativo de tu centro?`,
         icon: 'question',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         cancelButtonText: 'No, cancelar',
         confirmButtonText: 'Si, añadirlo.'
      }).then((result) => {
         if(result.value) {
            $.post(localStorage.getItem("hc_base_url") + "Centros_controller/agregarAdministrativo", {usuario: $(this).val()}, (data) => {
               if(data == 1) {
                  Swal.fire(
                     'Hecho',
                     `Se ha añadido a ${nombre} como administrativo`,
                     'success'
                   )
               }
            }).catch((e) => {
               if(e.responseText.includes("Duplicate entry")) {
                  Swal.fire(
                     'Error',
                     `${nombre} ya es administrativo de algun centro`,
                     'error'
                   )
               }
            })
         }
      })
   })
});