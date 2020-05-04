$(document).ready(() => {
   //primero ponemos el ciu del paciente en el campo de paciente
   let paciente = JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(p => p.seleccionado == true)[0];

   //si hay un paciente seleccionado lo ponemos en el input y cargamos los episodios
   if (paciente) {
      $("#pacienteInforme").val(paciente.CIU);
      cargarEpisodios(paciente.CIU);
   }

   //si cambiamos de paciente seleccionado, tambien lo hacemos en el formulario
   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => {
      $("#pacienteInforme").val(e.detail.CIU);
      cargarEpisodios(e.detail.CIU);
   });
});

function cargarEpisodios(ciu) {
   $.post(localStorage.getItem("hc_base_url") + "Pacientes_controller/leerEpisodios", { ciu: ciu }, (data) => {
      data = JSON.parse(data);

      //quitamos todos los episodios del select
      $("#episodio").html("");

      for (let episodio of data) {
         let option = document.createElement("option");
         option.value = episodio.id;
         option.innerText = episodio.descripcion;
         $("#episodio").append($(option));
      }

      //por ultimo añadimos una opcion extra para informes sin episodio
      let option = document.createElement("option");
      option.value = "NULL";
      option.innerText = "Ninguno";
      $("#episodio").append($(option));
   });
}