$(document).ready(() => {
   //lee los datos de inicio de este usuario
   $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data);

      $("#cantidad-pacientes").html(data.pacientes);
      $("#cantidad-facultativos").html(data.facultativos);
      $("#cantidad-administrativos").html(data.administrativos);
   });
});