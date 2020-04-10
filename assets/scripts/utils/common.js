//este archivo se cargará en gran parte de la aplicacion ya que es ampliamente usado
$(document).ready(function () {
   // ===== RELOJ =====
   let dias = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sabado");
   let meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

   function actualizarFecha() {
      let d = new Date();
      let cadena = "Hoy es ";
      cadena += dias[d.getUTCDay()] + " ";
      cadena += d.getUTCDate() + " de ";

      cadena += meses[d.getUTCMonth()] + " de ";
      cadena += d.getUTCFullYear();

      cadena += " | ";

      cadena += d.getHours() + ":";

      //si los minutos son de 0 a 9
      if (d.getMinutes().toString().length == 1) {
         //añade un 0 delante
         cadena += "0" + d.getMinutes();
      } else {
         //de lo contrario pone la fecha
         cadena += d.getMinutes();
      }
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
});