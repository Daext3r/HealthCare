$(document).ready(() => {
   //inicializamos el array de pruebas
   let pruebas = [];

   //cuando hagamos click en un titulo de categoria, la expandimos o contraemos
   $(".titulo").on("click", (e) => {
      //cambiamos el tamaño
      e.originalEvent.target.parentNode.classList.toggle("exp")
   });


   $(".pruebasSolicitadas").on("dragover", (e) => {
      //permitimos que se puedan soltar elementos aqui
      e.originalEvent.preventDefault();
   });

   $(".pruebasSolicitadas").on("drop", function (e) {
      //cuando soltamos, añadimos el dom elem a esta lista
      let elem = e.originalEvent.dataTransfer.getData("text/plain");
      elem = JSON.parse(elem);

      //inicializamos el valor del resultado a null
      elem.resultado = null;

      pruebas.push(elem);

      //buscamos el elemento que tenga el grupo de la prueba solicitada
      for (let categoria of this.children) {
         //si la categoria es este elemento
         if (categoria.children[0].innerText == elem.grupo) {

            //antes de añadir la nueva prueba, miramos que no esté ya
            for (let prueba of categoria.children[1].children) {
               if (prueba.innerText == elem.prueba) return;
            }

            let li = document.createElement("li");
            li.classList.add("prueba");
            li.innerText = elem.prueba;

            //añadimos la prueba a la categoria y quitamos el d-none
            categoria.children[1].appendChild(li);

            categoria.classList.remove("d-none");
         }
      }

      //buscamos esta prueba en la lista principal y la marcamos como ya seleccionada
      for (let categoria of $(".pruebasPosibles").children()) {
         if (categoria.children[0].innerText == elem.grupo) {
            for (let prueba of categoria.children[1].children) {
               if (prueba.innerText == elem.prueba) {
                  prueba.classList.add("seleccionado");
               }
            }
         }
      }

   });

   $(".prueba").on("dragstart", function (e) {
      //cuando empezamos a arrastrar, añadimos el dom elem al evento
      let info = {};
      info.grupo = this.parentNode.parentNode.children[0].innerText;
      info.prueba = this.innerText;
      e.originalEvent.dataTransfer.setData("text/plain", JSON.stringify(info));
   });

   $("#solicitar").on('click', async () => {
      if (pruebas.length <= 0) {
         //mostramos swal de errror y cancelamos
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No has seleccionado puebas'
         });

         return;
      }

      if($("div.seleccionado").children().eq(0).html() == undefined) {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No estás atendiendo a ningún paciente'
         });
         return;
      }

      let result = await Swal.fire({
         icon: 'question',
         title: 'Confirmación',
         text: `¿Quieres solicitar el análisis para ${$("div.seleccionado").children().eq(0).html()}`,
         showCancelButton: true,
         confirmButtonText: "Si",
         cancelButtonText: "Cancelar"
      });

      if (result.value) {
         let paciente = $("div.seleccionado")[0].dataset.CIU;

         $.post(localStorage.getItem("hc_base_url") + "Analiticas_controller/nuevaAnalitica", { paciente: paciente, pruebas: JSON.stringify(pruebas) }, (data) => {
            Swal.fire({
               icon:'success',
               title:'Hecho',
               text: `Se ha registrado la solicitud de la analítica para ${paciente}`
            }).then(() => window.location.reload());
         });
      }

   });
});