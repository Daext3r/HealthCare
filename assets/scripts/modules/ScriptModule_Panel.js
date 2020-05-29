//este archivo se cargará en gran parte de la aplicacion ya que es ampliamente usado
$(document).ready(function () {

   $("a").click(function (e) {
      //si queremos abrir en una pestaña nueva
      if (this.target == "_blank") {
         window.open(this.href);
         return;
      }

      e.preventDefault();
      $("section.contenido").eq(0).fadeOut(200);
      setTimeout(() => { window.location.href = this.href; }, 200);

   });

   $("section.contenido").eq(0).fadeIn(200);

   // ===== RELOJ =====
   let dias = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sabado");
   let meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

   function actualizarFecha() {
      let d = new Date();
      //formamos la cadena del reloj
      let cadena = `Hoy es ${dias[d.getUTCDay()]} ${d.getUTCDate()} de ${meses[d.getUTCMonth()]} de ${d.getUTCFullYear()} | 
      ${d.getHours()}:${d.getMinutes().toString().length == 1 ? "0" : ""}${d.getMinutes()}:${d.getSeconds().toString().length == 1 ? "0" : ""}${d.getSeconds()}`;

      //la mostramos 
      $("#reloj").text(cadena);
   }

   //ejecutamos la funcion de la fecha una vez
   actualizarFecha();

   //intervalo de ejecucion del reloj, cada minuto
   setInterval(actualizarFecha, 1000);

   //===== MENU LATERAL =====
   //para cada elemento del menu lateral
   for (let a of document.getElementsByTagName("a")) {
      //si el href coincide con la url actual
      if (a.href == window.location.href.split("?")[0]) {
         //añade la clase active para que resalte en azul
         a.children[0].classList.add("opcion-seleccionada")

         if (a.classList.contains("nested")) {
            a.parentNode.parentNode.classList.add("opcion-seleccionada");
         }
      }
   }

   //boton de logout
   $("#logout").on("click", () => {
      //si hace clic en el boton de logout, redirigimos al login
      //el propio login cierra la sesión
      window.location = localStorage.getItem("hc_base_url") + "login";
   });

   //cuando el documento se haya cargado, leemos las notificaciones
   $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerNotificaciones", {}, (data) => {
      //convertimos a JSON
      data = JSON.parse(data);

      //guardamos en el localstorage la cantidad de notificaciones
      localStorage.setItem("notificaciones", data.length);

      //mostramos la cantidad de notificaciones
      $("#notificaciones").text(localStorage.getItem("notificaciones"));

      for (let notificacion of data) {
         //creamos la notificacion con todos los datos correspondientes
         let notif = document.createElement("a");
         notif.innerText = notificacion.resumen;
         notif.href = "";
         notif.dataset.id = notificacion.id;

         $(notif).appendTo($("#listaNotificaciones"));

         //añadimos un event listener al elemento
         $(notif).on("click", function (e) {
            //evitamos que nos redirija 
            e.preventDefault();

            Swal.fire(
               {
                  'confirmButtonText': "Cerrar",
                  'icon': 'warning',
                  'title': `${notificacion.resumen}`,
                  'text': `${notificacion.informacion}`,
                  'onClose': (event) => {
                     //cuando cierra la notificacion es que ya la ha leido
                     //mandamos borrarla de la bbdd

                     $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/borrarNotificacion", { id: notificacion.id }, (data) => {

                        //reducimos la cantidad de notificaciones en uno en el localstorage
                        localStorage.setItem("notificaciones", parseInt(localStorage.getItem("notificaciones")) - 1);

                        //cuando se haya completado, actualizamos los contadores
                        $("#notificaciones").text(localStorage.getItem("notificaciones"));

                        $("#cantidad-notificaciones").text(localStorage.getItem("notificaciones"));

                        //this es el enlace al que hacemos clic, puesto que despues de el enlace usamos funciones lambda para no generar un nuevo this
                        $(this).remove();
                     });
                  }
               }
            )
         });
      }
   });

   $("#modificarDatosGuardar").click((e) => {
      e.preventDefault();
      Swal.fire({
         icon: 'question',
         title: 'Guardar cambios',
         text: '¿Desea guardar los cambios?',
         showCancelButton: true,
         cancelButtonText: 'No',
         confirmButtonText: 'Si'
      }).then((e) => {
         if (e.value) {

            var file = document.getElementById("imagenPerfil").files[0];
            var img; //imagen codificada en base64

            //comprobamos si ha subido una imagen
            if (file) {
               var reader = new FileReader();
               reader.onloadend = function () {
                  img = reader.result;

                  let datos = {};
                  datos.fijo = $("#perf-fijo").val();
                  datos.direccion = $("#perf-direccion").val();
                  datos.telefono = $("#perf-telefono").val();
                  datos.correo = $("#perf-correo").val();
                  datos.img = img;

                  $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/actualizarUsuario", datos, (data) => {
                     if (data == 1) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Hecho',
                           text: 'Se han actualizado los datos'
                        }).then((e) => {
                           $("#modificarDatos").modal("toggle");
                        })
                     }
                  });
               }
               reader.readAsDataURL(file);
            } else {
               let datos = {};
               datos.fijo = $("#perf-fijo").val();
               datos.direccion = $("#perf-direccion").val();
               datos.telefono = $("#perf-telefono").val();
               datos.correo = $("#perf-correo").val();

               $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/actualizarUsuario", datos, (data) => {
                  if (data == 1) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Hecho',
                        text: 'Se han actualizado los datos'
                     }).then((e) => {
                        $("#modificarDatos").modal("toggle");
                     })
                  }
               });
            }
         }
      })
   });

   $("#cambiarClave").click((e) => {
      e.preventDefault();
      $("#modificarDatos").modal("toggle");
      Swal.fire({
         icon: 'question',
         title: 'Cambiar clave',
         input: 'password',
         inputPlaceholder: 'Introduce tu nueva clave',
         showCancelButton: true,
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Cambiar'
      }).then((e) => {
         if (!e.value) return;

         $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/cambiarClave", { clave: e.value }, (data) => {
            if (data == 1) {
               Swal.fire({
                  icon: 'success',
                  title: 'Hecho',
                  text: 'Se ha cambiado tu clave correctamente'
               })
            }
         })
      });
   });

   $("#toggle-menu").children().eq(0).click(() => {
      //añadimos al body una clase que ocultara el menu
      document.getElementsByTagName("body")[0].classList.toggle("toggle-menu");
   })
});

