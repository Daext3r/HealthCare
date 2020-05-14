//script que se cargará en el apartado inicio del paciente

$(document).ready(function () {
   //tenemos que poner null al principio dada la naturaleza del array_search que usamos en el modelo
   $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data)[0];
      $("#cantidad-citas").html(data.citas);
      $("#cantidad-tratamientos").html(data.tratamientos);
      $("#cantidad-notificaciones").html(data.notificaciones);
   });
});