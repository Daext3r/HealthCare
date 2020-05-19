$(document).ready(() => {
   //si la pantalla no cumple con los requisitos de tamaño, evitamos que pueda iniciar sesión.
   if(window.outerWidth < 1130) {
      $(".row")[0].style.display = "none";
      $("body").append($("<h3>Lo sentimos, tu dispositivo no está optimizado para nuestro sitio :(</h3>"));
   }
});