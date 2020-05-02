//este archivo se cargará en gran parte de la aplicacion ya que es ampliamente usado
$(document).ready(function () {

   $("section.contenido").eq(0).fadeIn(500);

   // ===== RELOJ =====
   let dias = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sabado");
   let meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

   function actualizarFecha() {
      let d = new Date();
      //formamos la cadena del reloj
      let cadena = `Hoy es ${dias[d.getUTCDay()]} ${d.getUTCDate()} de ${meses[d.getUTCMonth()]} de ${d.getUTCFullYear()} | 
      ${d.getHours()}:${d.getMinutes().toString().length == 1 ? "0":""}${d.getMinutes()}`;

      //la mostramos 
      $("#reloj").text(cadena);
   }

   //ejecutamos la funcion de la fecha una vez
   actualizarFecha();

   //intervalo de ejecucion del reloj, cada minuto
   setInterval(actualizarFecha, 60000);

   //===== MENU LATERAL =====
   //para cada elemento del menu lateral
   for (let a of document.getElementsByClassName("list-group")[0].children) {
      //si el href coincide con la url actual
      if (a.href == window.location.href) {
         //añade la clase active para que resalte en azul
         a.children[0].classList.add("active");
      }
   }

   //boton de logout
   $("#logout").on("click", () => {
      //si hace clic en el boton de logout, redirigimos al login
      //el propio login cierra la sesión
      window.location = localStorage.getItem("hc_base_url") + "login";
   });

      //cuando el documento se haya cargado, leemos las notificaciones
      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerNotificaciones", {}, (data) => {
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
   
                        $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/borrarNotificacion", { id: notificacion.id }, (data) => {
   
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
});