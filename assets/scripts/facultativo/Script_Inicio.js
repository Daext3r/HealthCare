$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/leerDatosInicio", {}, (data) => {
      data = JSON.parse(data)[0];
      console.log(data);
      $("#cantidad-citas").html(data.citas);
      $("#cantidad-informes").html(data.informes);
      $("#cantidad-pacientes").html(data.pacientes);
   });
});