$(document).ready(function () {
   $("#CIU_gerente").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#gerentes").html("");

      //si el input esta vacio, no busca nada
      if ($("#CIU_gerente").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $("#CIU_gerente").val() }, (data) => {
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

   //cuando se seleccione un gerente, quitamos el foco del elemento para que no vuelva a salir la lista
   $("#CIU_gerente").change(() => {
      $("#enviar").focus();
   });

   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
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
   
   //este evento se dispara cuando se cambia el valor del input
   //se cambia cuando hagamos clic en una opcion
   //lo usaremos para detectar cuando el usuario ha seleccionado una opcion del datalist
   $("#centro").change(function () {
      $.post(localStorage.getItem("hc_base_url") + "Centros_controller/leerDatosCentro", { centro: $(this).val() }, (data) => {
         data = JSON.parse(data);

         //si es menor a 0, es que no ha seleccionado un centro de la lista
         if(data.length <= 0) return;

         //cuando se complete la peticion, borramos el formulario de la pantalla
         $("#buscador").fadeOut(300);

         console.log(data);
         for (let i in data) {
            $(`#${i}`).val(`${data[i]}`);
         }

         let numerosInput = $("#telefonos").val().split(',');

         $("#telefonos").val("");
         //por cada numero, lo parseamos y lo guardamos en el array y lo mostramos debajo
         for (let numero of numerosInput) {
            numeros.push(numero);

            //creamos un span y lo ponemos en la lista de telefonos de debajo
            let span = document.createElement("span");
            span.classList.add("caja");

            let num = document.createElement("span");
            num.innerText = numero;
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

         //escribimos los datos en el resto de inputs
         setTimeout(() => { $(".datos").fadeIn(300); }, 500);
      });
   });

   //contiene la lista de numeros de telefonos del centros
   var numeros = [];
   //EVENTO DE AÑADIR NUMEROS DE TELEFONO
   $("input.telefonos").keyup(function (e) {
      //188 es la tecla ,
      if (e.keyCode == 188) {
         //guardamos el telefono en el array y limpiamos el input
         //convertimos en array, leemos el valor desde 0 hasta el index de la coma, y lo volvemos a convertir en string. asi quitamos la coma del input
         let telefono = $(this).val().trim().split('').slice(0, $(this).val().indexOf(',')).join('');
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

   //EVENTO DE ENVIO DEL FORMULARIO
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

      console.log(datos);
 
      $.post(localStorage.getItem("hc_base_url") + "Centros_controller/actualizarCentro", datos, (data) => {
         console.log(data);
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: 'Se han actualizado los datos del centro correctamente',
            });
         }
      }).catch(() => {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            html: 'Ha ocurrido un error al actualizar los datos del centro<br><small>Recuerda que un usuario no puede ser gerente de dos centros al mismo tiempo</small>',
         });
      });
   })
});