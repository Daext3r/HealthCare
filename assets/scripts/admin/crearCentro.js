$(document).ready(() => {

   //contiene la lista de numeros de telefonos del centros
   var numeros = [];
   $("input.telefonos").keyup(function (e) {
      if (e.keyCode == 188) {
         //guardamos el telefono en el array y limpiamos el input
         //convertimos en array, leemos el valor desde 0 hasta el index de la coma, y lo volvemos a convertir en string. asi quitamos la coma del input
         let telefono = $(this).val().split('').slice(0, $(this).val().indexOf(',')).join('');
         numeros.push(telefono);
         $(this).val("");

         //creamos un span y lo ponemos en la lista de telefonos de debajo
         let span = document.createElement("span");
         span.classList.add("caja");

         let num = document.createElement("span");
         num.innerText = telefono;
         span.appendChild(num);

         let cruz = document.createElement("span");
         cruz.innerHTML = "&times;";
         cruz.classList.add("cruz");

         cruz.addEventListener("click", function (e) {
            numeros.splice(numeros.indexOf(this.parentNode.children[0].innerText), 1);
            $(this.parentNode).remove();

         });

         span.appendChild(cruz);

         $("div.telefonos").append($(span));
      }
   });

   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#gerente").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#gerentes").html("");

      //si el input esta vacio, no busca nada
      if ($("#gerente").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $("#gerente").val() }, (data) => {
            data = JSON.parse(data);
            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#gerentes").append($(option));
            }
         });
      }, 700);
   });

   $("#form").submit(function (e) {
      e.preventDefault();

      //comprobamos que haya al menos un numero
      if (numeros.length <= 0) {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debes poner al menos un número',
         });
         return;
      }

      //comprobamos que la hora de apertura sea menor a la de cierre
      if (parseInt($("#hora_apertura").val()) >= parseInt($("#hora_cierre").val())) {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La hora de apertura no puede ser igual o mayor a la de cierre',
         });
         return;
      }

      //guardamos los datos del formulario, añadimos los numeros de telefono y los enviamos al servidor
      let datos = $("#form").serializeArray();
      datos.push({ name: 'telefonos', value: numeros.join(',') });

      $.post(localStorage.getItem("hc_base_url") + "Centros_controller/crearCentro", datos, (data) => {
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: 'Se ha creado el centro correctamente',
            });
         }
      }).catch(() => {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            html: 'Ha ocurrido un error al crear el centro<br><small>Recuerda que un usuario no puede ser gerente de dos centros al mismo tiempo</small>',
         });
      });
   })
});