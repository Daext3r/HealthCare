$(document).ready(function () {

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

   //este evento se dispara cuando se cambia el valor del input
   //se cambia cuando hagamos clic en una opcion
   //lo usaremos para detectar cuando el usuario ha seleccionado una opcion del datalist
   $("#usuario").change(function () {
      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerDatosUsuario", { ciu: $(this).val() }, (data) => {
         data = JSON.parse(data);

         //si es menor a 0, es que no ha seleccionado un usuario de la lista
         if (data.length <= 0) return;

         //cuando se complete la peticion, borramos el formulario de la pantalla
         $("#buscador").fadeOut(300);

         for (let i in data) {
            $(`#${i}`).val(`${data[i]}`);
         }

         //llamamos a la funcion que escribe la letra del dni
         escribirLetra();

         //escribimos los datos en el resto de inputs
         setTimeout(() => { $(".datos").fadeIn(300); }, 500);
      });
   });

   //cuando hagamos clic en el input, borramos todos los datos del datalist
   $("#usuario").focus(function () { $("#usuarios").html("") });

   $("#form").submit(function (e) {
      e.preventDefault();

      //si la letra del dni es - significa que el dni no es valido
      if ($("#letraDni").html() == "-") {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El DNI no es válido. Debe tener 8 números, añade ceros a la izquierda si es necesario',
         });
         return;
      }

      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/actualizarUsuario", $(this).serializeArray(), (data) => {
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: 'Se han actualizado los datos del usuario correctamente',
            });
         }
      }).catch(() => {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al actualizar los datos. Revisa que el DNI sea correcto y no pertenezca a otro usuario',
         });
      });
   });

   $("#restaurarClave").click(() => {
      Swal.fire({
         icon: 'question',
         title: 'Confirmación',
         text: '¿Estás seguro de que quieres restaurar la clave del usuario?',
         showCancelButton: true,
         cancelButtonText: 'No',
         showConfirmButton: true,
         confirmButtonText: 'Si'
      }).then((e) => {
         //si no le ha dado a si, cancelamos
         if (e.value) {
            $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/restaurarClave", { ciu: $("#usuario").val() }, (data) => {
               if (data == 1) {
                  Swal.fire({
                     icon: 'success',
                     title: 'Hecho',
                     text: 'Se restaurado la clave del usuario correctamente',
                  });
               }
            })
         }
      });


   });
});