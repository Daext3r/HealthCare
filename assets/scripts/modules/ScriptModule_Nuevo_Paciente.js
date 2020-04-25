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
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioNombre", { nombre: $("#usuario").val() }, (data) => {
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
      let grupo_sanguineo = $("#grupo_sanguineo").val().trim();
      let medico = $("#fac1").val().trim();
      let enfermero = $("#fac2").val().trim();

      //si los campos no estan rellenos, no hacemos nada
      if (medico == "") return;
      if (enfermero == "") return;
      if (grupo_sanguineo == "") return;

      $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/alta", { usuario: $("#usuario").val(), grupo_sanguineo: grupo_sanguineo, medico: medico, enfermero: enfermero }, (data) => {
         if (data == 1) {
            Swal.fire(
               'Hecho',
               `Se ha registrado al usuario ${$("#usuario").val()} como paciente`,
               'success'
            )
         }
      });
   });

   $("#fac1").keyup(function () {
      //borramos la busqueda anterior y quitamos los elementos existentes
      clearInterval(interval);
      $("#fac1list").html("");

      interval = setTimeout(() => {
         $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/buscarFacultativoNombre", { nombre: $(this).val() }, (data) => {
            data = JSON.parse(data);
            console.log(data);
            for (let facultativo of data) {
               let option = document.createElement("option");
               option.value = facultativo.CIU;
               option.innerText = facultativo.nombre_completo;

               $("#fac1list").append($(option));
            }
         });
      }, 700)
   });

   $("#fac2").keyup(function () {
      console.log("test");
      //borramos la busqueda anterior y quitamos los elementos existentes
      clearInterval(interval);
      $("#fac2list").html("");

      interval = setTimeout(() => {
         $.post(localStorage.getItem("hc_base_url") + "Facultativos_controller/buscarFacultativoNombre", { nombre: $(this).val() }, (data) => {
            data = JSON.parse(data);

            for (let facultativo of data) {
               let option = document.createElement("option");
               option.value = facultativo.CIU;
               option.innerText = facultativo.nombre_completo;

               $("#fac2list").append($(option));
            }
         });
      }, 700)
   });

});