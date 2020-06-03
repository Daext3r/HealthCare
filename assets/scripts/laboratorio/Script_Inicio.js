$(document).ready(() => {
   //lee los datos de inicio
   $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data);

      $("#cantidad-pendientes").html(data[0].pendientes);
      $("#cantidad-cerradas").html(data[0].cerradas);
      $("#cantidad-realizadas").html(data[0].realizadas);
   });
})