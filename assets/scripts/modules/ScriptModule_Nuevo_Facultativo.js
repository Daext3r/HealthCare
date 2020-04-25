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
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioNombre", { ciu: $("#usuario").val() }, (data) => {
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

         //escribimos los datos en el resto de inputs
         setTimeout(() => { $(".datos").fadeIn(300); }, 500);
      });
   });

   //cuando hagamos clic en el input, borramos todos los datos del datalist
   $("#usuario").focus(function () { $("#usuarios").html("") });


   $("#registrar").click(() => {
      //verificamos los datos
      let colegiado = $("#colegiado").val().trim();
      let sala = $("#sala").val().trim();
      let centro = $("#centro").val().trim();
      let especialidad = $("#especialidad").val().trim();

      //si el valor de estos campos no es numerico
      if(isNaN(especialidad)) return;
      if(isNaN(centro)) return;

      //si los campos no estan rellenos, no hacemos nada
      if (colegiado == "") return;
      if (sala == "") return;
      if (especialidad == "") return;

      $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/alta", { usuario: $("#usuario").val(), colegiado: colegiado, sala: sala, especialidad: especialidad, centro : centro }, (data) => {
         if (data == 1) {
            Swal.fire(
               'Hecho',
               `Se ha registrado al usuario ${$("#usuario").val()} como facultativo`,
               'success'
             )
         }
      });
   });

   $("#especialidad").keyup(function () {
      //borramos la busqueda anterior y quitamos los elementos existentes
      clearInterval(interval);
      $("#especialidades").html("");

      interval = setTimeout(() => {
         $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/buscarEspecialidad", { especialidad: $(this).val() }, (data) => {
            data = JSON.parse(data);

            for (let especialidad of data) {
               let option = document.createElement("option");
               option.value = especialidad.id;
               option.innerText = especialidad.denominacion;

               $("#especialidades").append($(option));
            }
         });
      }, 700)
   });

   $("#centro").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#centros").html("");

      //si el input esta vacio, no busca nada
      if ($("#centro").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Centros_controller/buscarCentroNombre", { centro: $("#centro").val() }, (data) => {
            data = JSON.parse(data);
            for (let centro of data) {
               let option = document.createElement("option");
               option.value = centro.id;
               option.innerText = centro.nombre;
               $("#centros").append($(option));
            }
         });
      }, 700);
   });
});