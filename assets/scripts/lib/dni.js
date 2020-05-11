
//declaramos el array con las letras del dni
var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

$(document).ready(function () {
   $("#dni").keydown(function (e) {
      //si ya tiene 8 dijitos evitamos que siga escribiendo
      //no lo hago en html porque no funciona en todos los navegadores
      //teclas de borrar suprimir y tabulador, respectivamente

      if ($(this).val().length == 8 && e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 9) {
         e.preventDefault();
      }
   });

   $("#dni").keyup(function (e) {
      if ($(this).val().length == 8) {
         escribirLetra();
      } else {
         $("#letraDni").html("-");
      }
   });
})

function escribirLetra() {
   $("#letraDni").html(letras[parseInt($("#dni").val() % 23)]);
}