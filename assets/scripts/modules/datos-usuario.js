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
         console.log(data);
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

});