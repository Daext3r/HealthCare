let listaInformes = [];
//cuando el documento se haya cargado
$(document).ready(async function () {


   //leemos los informes de este usuario en la base de datos
   //esperamos a que se termine la funcion
   await $.post(localStorage.getItem("hc_base_url") + "Informes/leerListaInformes", { propio: true }, (data) => {
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

   //por cada informe miramos el facultativo y lo agregamos al select
   let listaFacultativos = [];
   for (let informe of listaInformes) {
      //si es -1 es que no está en el array
      if (listaFacultativos.indexOf(informe.facultativo) == -1) {
         listaFacultativos.push(informe.facultativo);
      }
   }

   for (let facultativo of listaFacultativos) {
      let option = document.createElement("option");
      option.value = facultativo;
      option.innerText = facultativo;

      $("#facultativo").append($(option));
   }

   //cada vez que se cambie uno de estos campos actualizamos los informes
   $("#especialidad").change(mostrarInformes);
   $("#facultativo").change(mostrarInformes);
   $("#privados").change(mostrarInformes);

   $("#reset").click(() => {
      //reseteamos los filtros y mostramos los informes
      $("#especialidad").val("todas");
      $("#facultativo").val("cualquiera");
      $("#privados").val("1");

      mostrarInformes();
   });
});

function mostrarInformes() {
   let nuevaLista = [];

   //miramos que el valor de especialidad no sea 'todas'
   if ($("#especialidad").val() != "todas") {
      nuevaLista = listaInformes.filter(informe => informe.especialidad == $("#especialidad").val());
   } else {
      nuevaLista = listaInformes;
   }

   //miramos que el valor de facultativo no sea 'cualquiera'
   if ($("#facultativo").val() != "cualquiera") {
     nuevaLista = nuevaLista.filter(informe => informe.facultativo == $("#facultativo").val());
   }

   //si el usuario no quiere ver los informes privados
   if ($("#privados").val() == "0") {
      nuevaLista = nuevaLista.filter(informe => informe.privado == $("#privados").val());
   }

   console.log(nuevaLista);
   //mostramos la nueva lista en pantalla
   $("#lista").html("");
   for (let informe of nuevaLista) {
      generarInforme(informe);
   }


}

function generarInforme(informe) {
   console.log(informe);
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
      <div class="enlace"><a href="${localStorage.getItem("hc_base_url")}/Informes/ver/${informe.id}" target="_blank">Ver Informe</a></div>
   </div>
   `);


   $("#lista").append($(elem));
}



