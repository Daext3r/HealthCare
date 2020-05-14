$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data)[0];
      $("#cantidad-usuarios").html(data.usuarios);
      $("#cantidad-centros").html(data.centros);
      $("#cantidad-tratamientos").html(data.tratamientos);
   });
});