$(document).ready(function () {
   $("#form").submit(function (e) {
      //el formulario se enviará cuando todos los campos estén rellenos
      e.preventDefault();

      let datos = $(this).serializeArray();
      //si no ha introducido al menos dos apellidos mostramos error
      if (datos[1].value.split(" ").length < 2) {
         Swal.fire(
            'Error',
            'Debes introducir al menos dos apellidos',
            'error'
         );
         return;
      }

      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/registrarUsuario", datos, (data) => {
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: '¡Usuario registrado! Recuerda asignarle un perfil',
               //hacemos que recargue la pagina al cerrar
               onClose: () => { location.reload() }
            });
         }
      }).catch((e) => {
         if (e.responseText.includes("for key 'correo'")) {
            Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'El correo ya está en uso por otro usuario'
            });
         }
      })
   })
});