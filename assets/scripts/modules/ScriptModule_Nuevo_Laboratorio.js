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
         $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/buscarUsuarioNombre", { ciu: $("#usuario").val() }, (data) => {
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
      $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerDatosUsuario", { ciu: $(this).val() }, (data) => {
         data = JSON.parse(data);

         //si es menor a 0, es que no ha seleccionado un usuario de la lista
         if (data.length <= 0) return;

         $("#centro").focus();
      });
   });

   //cuando hagamos clic en el input, borramos todos los datos del datalist
   $("#usuario").focus(function () { $("#usuarios").html("") });

   $("#centro").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#centros").html("");

      //si el input esta vacio, no busca nada
      if ($("#centro").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "API/Centros/buscarCentroNombre", { centro: $("#centro").val() }, (data) => {
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

   $("#centro").change(() => $("#registrar").focus());

   $("#registrar").click(() => {
      let usuario = $("#usuario").val().trim();
      let centro = $("#centro").val().trim();

      $.post(localStorage.getItem("hc_base_url") + "API/Laboratorio/registrarPersonal", { usuario: usuario, centro: centro }, (data) => {
         if (data == 1) {
            Swal.fire(
               'Hecho',
               'Se ha registrado al usuario como personal de laboratorio',
               'success'
            )
         }
      });
   });
})