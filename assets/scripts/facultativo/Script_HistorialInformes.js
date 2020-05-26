let listaInformes = [];
//cuando el documento se haya cargado
$(document).ready(async function () {
   await buscarInformesPaciente();

   //comprobamos si se ha pasado informe por get
   let episodio = window.location.search.split("=");
   if (episodio[0] == "?episodio") {

      for (let child of document.getElementById("episodio").children) {
         if (child.value == episodio[1]) {
            child.setAttribute("selected", "");
            console.log("found");
         }
      }
      mostrarInformes();
   }

   //cada vez que se cambie uno de estos campos actualizamos los informes
   $("#especialidad").change(mostrarInformes);
   $("#episodio").change(mostrarInformes);
   $("#desde").change(mostrarInformes);
   $("#hasta").change(mostrarInformes);

   $("#reset").click(() => {
      //reseteamos los filtros y mostramos los informes
      $("#especialidad").val("todas");
      $("#episodio").val("todos");
      $("#desde").val("");
      $("#hasta").val("");

      mostrarInformes();
   });

   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => {
      buscarInformesPaciente();
   });
});

async function buscarInformesPaciente() {
   //borramos los informes que ya haya
   $("#lista").html("");
   $("#episodio").html("<option value='todos' selected>Todos</option>");
   $("#especialidad").html("<option value='todas' selected>Todas</option>");

   //añadimos las opciones por defecto

   listaInformes = [];

   //leemos los informes del usuario seleccionado en la base de datos
   //esperamos a que se termine la funcion
   let seleccionado = JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(paciente => paciente.seleccionado == true);

   //si no se ha podido seleccionar un paciente, volvemos atras
   if (!seleccionado) return;

   await $.post(localStorage.getItem("hc_base_url") + "Informes/leerListaInformes", { propio: false, ciu: seleccionado[0].CIU }, (data) => {
      data = JSON.parse(data);

      //por cada informe
      for (let informe of data) {
         //guardamos los informes en el array de informes
         listaInformes.push(new Informe(informe.id, informe.privado, informe.episodio, informe.fecha, informe.nombre_completo_medico, informe.especialidad));
      }
   });

   //por cada informe creamos un elemento del DOM y se lo asignamos
   for (let informe of listaInformes) {
      generarInforme(informe);
   }

   //por cada informe miramos su especialidad y la agregamos al select
   let listaEspecialidades = [];
   for (let informe of listaInformes) {
      //si es -1 es que no está en el array
      if (listaEspecialidades.indexOf(informe.especialidad) == -1) {
         listaEspecialidades.push(informe.especialidad);
      }
   }
   for (let especialidad of listaEspecialidades) {
      let option = document.createElement("option");
      option.value = especialidad;
      option.innerText = especialidad;

      $("#especialidad").append($(option));
   }

   //por cada informe miramos el episodio y lo agregamos al select
   let listaEpisodios = [];
   for (let informe of listaInformes) {
      //si es -1 es que no está en el array
      if (listaEpisodios.indexOf(informe.episodio) == -1) {
         listaEpisodios.push(informe.episodio);
      }
   }

   for (let episodio of listaEpisodios) {
      let option = document.createElement("option");
      option.value = episodio;
      option.innerText = episodio;

      $("#episodio").append($(option));
   }
}

function mostrarInformes() {
   let nuevaLista = [];
   //miramos que el valor de especialidad no sea 'todas'
   if ($("#especialidad").val() != "todas") {
      nuevaLista = listaInformes.filter(informe => informe.especialidad == $("#especialidad").val());
   } else {
      nuevaLista = listaInformes;
   }

   if ($("#episodio").val() != "todos") {
      nuevaLista = nuevaLista.filter(informe => informe.episodio == $("#episodio").val());
   }

   if ($("#desde").val() != "") {
      nuevaLista = nuevaLista.filter(informe => new Date(informe.fecha).getTime() >= new Date($("#desde").val()).getTime());
   }


   if ($("#hasta").val() != "") {
      nuevaLista = nuevaLista.filter(informe => new Date(informe.fecha).getTime() <= new Date($("#hasta").val()).getTime());
   }

   //mostramos la nueva lista en pantalla
   $("#lista").html("");
   for (let informe of nuevaLista) {
      generarInforme(informe);
   }
}

function generarInforme(informe) {
   let elem = $(`
   <div class="alert alert-secondary">
      <div>Especialidad: ${informe.especialidad}</div>
         <div>Facultativo: ${informe.facultativo}</div>
         <div class="row">
            <div class="col">
               <div>Privado: ${informe.privado == 1 ? "Si" : "No"}</div>
            </div>
            <div class="col">
               <div>Fecha: ${new Date(informe.fecha).toLocaleDateString()}</div>
            </div>
         </div>
      <div class="enlace"><a href="${localStorage.getItem("hc_base_url")}Informes/ver/${informe.id}" target="_blank">Ver Informe</a></div>
   </div>
   `);


   $("#lista").append($(elem));
}



