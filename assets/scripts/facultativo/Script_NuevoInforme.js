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

   $("#privado").click(function () {
      let estadoActual = this.dataset.privado;

      if (estadoActual == "true") {
         //si esta privado lo ponemos como publico
         this.dataset.privado = "false";

         //cambiamos la clase y el icono
         this.classList.remove("btn-danger");
         this.classList.add("btn-success");
         this.innerHTML = "<i class='fas fa-unlock'></i>";
      } else {
         //si esta publico lo ponemos como privado
         this.dataset.privado = "true";

         //cambiamos la clase y el icono
         this.classList.remove("btn-success");
         this.classList.add("btn-danger");
         this.innerHTML = "<i class='fas fa-lock'></i>";
      }
   });

   $("#guardar").click(() => {
      //guardamos el contenido del informe en una variable y separamos por palabras
      let texto = document.getElementById("contenidoInforme").innerText.split(" ");

      //por cada index del array, lo partiremos en otro array basandonos en los saltos de linea, \n
      for (let i in texto) {
         //si la longitud al partirlo en array es mayor a 1, es que tiene mas de un elemento y hay salto de linea
         if (texto[i].split("\n").length > 1) {
            let nuevaParte = [];
            nuevaParte.push(texto[i].split("\n").shift());

            for (let n = 0; n < texto[i].split("\n").length / 2; n++) {
               nuevaParte.push("\n");
            }

            nuevaParte.push(texto[i].split("\n").pop());

            //guardamos en texto la nueva parte, que contendrá el formato
            texto[i] = nuevaParte;
         }
      }

      //en este punto la variable texto tiene dos tipos de valor. palabras, o arrays que contienen palabras y una cantidad de saltos de linea
      //creamos un div que contendrá todas las paginas que necesitamos
      var paginas = document.createElement("div");
      paginas.style.position = "absolute";
      paginas.style.left = "-3000px";
      paginas.id = "listaPaginas"
      document.getElementsByTagName("body")[0].appendChild(paginas);

      let paginaActual;

      //creamos un div de pagian y le ponemos su clase
      paginaActual = document.createElement("div");
      paginaActual.classList.add("pagina");

      //agregamos la pagina actual a la lista de paginas
      paginas.appendChild(paginaActual);

      for (let palabra of texto) {
         //primero comprobamos si la palabra es un array
         if (Array.isArray(palabra)) {
            //si es array lo recorremos
            for (let i in palabra) {
               //miramos si la palabra es un salto de linea o una palabra
               if (palabra[i] != "\n") {
                  //miramos si nos devuelve false. en ese caso creamos una nueva pagina y volvemos a intentar
                  if (agregarPalabra(palabra[i], paginaActual) == false) {
                     //creamos un div de pagian y le ponemos su clase
                     paginaActual = document.createElement("div");
                     paginaActual.classList.add("pagina");

                     //agregamos la pagina actual a la lista de paginas
                     paginas.appendChild(paginaActual);
                  }
               } else {
                  //miramos si nos devuelve false. en ese caso creamos una nueva pagina y volvemos a intentar
                  if (agregarPalabra(palabra[i], paginaActual) == false) {
                     //creamos un div de pagian y le ponemos su clase
                     paginaActual = document.createElement("div");
                     paginaActual.classList.add("pagina");

                     //agregamos la pagina actual a la lista de paginas
                     paginas.appendChild(paginaActual);
                  }
               }
            }
         } else {
            //si no es array lo intentamos añadir al texto
            //miramos si nos devuelve false. en ese caso creamos una nueva pagina y volvemos a intentar
            if (agregarPalabra(palabra, paginaActual) == false) {
               //creamos un div de pagian y le ponemos su clase
               paginaActual = document.createElement("div");
               paginaActual.classList.add("pagina");

               //agregamos la pagina actual a la lista de paginas
               paginas.appendChild(paginaActual);
            }
         }
      }

      //por ultimo declaramos una cadena de texto que será el texto dividido en paginas, y lo juntamos en una cadena preparada para mandarla al servidor
      let textoPaginas = [];
      console.log(paginas);
      for (let pagina of paginas.children) {
         textoPaginas.push(pagina.innerText);
      }

      //guardamos el informe
      $.post(localStorage.getItem("hc_base_url") + "Informes/guardarInforme", { contenido: textoPaginas.join("===NEW_PAGE==="), paciente: $("#pacienteInforme").val(), episodio: $("#episodio").val(), privado: $("#privado")[0].dataset.privado == "true" ? 1 : 0 }, async (data) => {
         if (data == 1) {
            await Swal.fire(
               'Hecho',
               'Se ha guardado el informe',
               'success'
            );

            window.location.reload();
         }
      });
   });
});

function agregarPalabra(palabra, paginaActual) {
   palabra += " ";
   //si la altura actual de la pagina no es menor a 960, devolvemos false
   if (paginaActual.offsetHeight < 960) {
      //añadimos la palabra a la pagina
      paginaActual.innerText += palabra;

      //miramos que la altura sea menor a 960
      if (paginaActual.offsetHeight < 960) {
         return true;
      } else {
         //si la palabra no cabe, quitamos la palabra y devolvemos false
         paginaActual.innerText = paginaActual.innerText.substring(0, paginaActual.innerText.length - palabra.length);
         return false;
      }
   } else {
      return false;
   }
}

function cargarEpisodios(ciu) {
   $.post(localStorage.getItem("hc_base_url") + "API/Pacientes/leerEpisodios", { ciu: ciu }, (data) => {
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