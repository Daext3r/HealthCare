//evento de documento cargado
$(document).ready(() => {
   //añadimos al localstorage la url base. lo hacemos aqui ya que se usará en varias partes de la aplicación
   localStorage.setItem("hc_base_url", "http://localhost/HealthCare/");

   $("#iniciar-sesion").on("click", function (e) {
      //si no hay correo o clave y ademas tampoco hay token, hay cancelamos el evento
      if ($("#correo").val().trim() == "" && $("#jwt").val() == "") { e.preventDefault(); }
      if ($("#clave").val().trim() == "" && $("#jwt").val() == "") { e.preventDefault(); }
   });

   $(".seleccion").on("click", function (e) {
      if (this.dataset.seleccion == "si") {
         //si el usuario dice que es el, enviamos el formulario
         $("#jwt").val(localStorage.getItem("jwt"));

         setTimeout(() => {$("#form").submit()}, 100);;

      } else if (this.dataset.seleccion == "no") {
         //si el usuario dice que no es el, mostramos el login y borramos los datos
         localStorage.setItem("jwt", "");
         localStorage.setItem("correo", "");
         $("#seleccion").fadeOut(500);

         setTimeout(() => {
            $("#form").fadeIn(800);
         }, 500);
      }
   });


   //comprobamos si existe el token JSON
   if (localStorage.getItem("jwt") != undefined && localStorage.getItem("jwt") != "") {
      //si hay token preguntamos por el nombre del usuario
      $("#load").fadeOut(500);
      $("#seleccion-correo").html(localStorage.getItem("correo"));

      setTimeout(() => {
         $("#seleccion").fadeIn(800);
      }, 500);

   } else {
      //si el token no existe, mostramos el formulario de login
      $("#load").fadeOut(500);

      setTimeout(() => {
         $("#form").fadeIn(800);
      }, 500);
   }
});