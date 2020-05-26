$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "API/Usuarios/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data);

      $("#cantidad-citas").html(data[0].citas);
      $("#cantidad-facultativos").html(data[0].facultativos);
      $("#cantidad-pacientes").html(data[0].pacientes);
      
   });
});