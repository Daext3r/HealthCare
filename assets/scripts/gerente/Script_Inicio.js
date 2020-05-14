$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data);

      $("#cantidad-pacientes").html(data.pacientes);
      $("#cantidad-facultativos").html(data.facultativos);
      $("#cantidad-administrativos").html(data.administrativos);
   });
});