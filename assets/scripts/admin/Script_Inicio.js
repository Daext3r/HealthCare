$(document).ready(() => {
   //leemos los datos de inicio y los mostramos en el menú
   $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data)[0];
      $("#cantidad-usuarios").html(data.usuarios);
      $("#cantidad-centros").html(data.centros);
      $("#cantidad-tratamientos").html(data.tratamientos);
   });
});