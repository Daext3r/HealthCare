//declaramos el array con las letras del dni
var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

$(document).ready(function () {
   $("#dni").keydown(function (e) {
      //si ya tiene 8 dijitos evitamos que siga escribiendo
      //no lo hago en html porque no funciona en todos los navegadores
      // teclas de borrar y suprimir, respectivamente

      if ($(this).val().length == 8 && e.keyCode != 8 && e.keyCode != 46) {
         e.preventDefault();
      }
   });

   $("#dni").keyup(function (e) {
      if ($(this).val().length == 8) {
         $("#letraDni").html(letras[parseInt($(this).val() % 23)]);
      } else {
         $("#letraDni").html("-");
      }
   });

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
      } else {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/registrarUsuario", datos, (data) => {
            if(data == 1) {
               Swal.fire({
                  icon : 'success',
                  title: 'Hecho',
                  text:'¡Usuario registrado! Recuerda asignarle un perfil',
                  //hacemos que recargue la pagina al cerrar
                  onClose: () => {location.href = ""}
               });
            } else {
               Swal.fire(
                  'Error',
                  'No se ha podido registrar al usuario, revisa los datos',
                  'error'
               );
            }
         });
      }
   })
});