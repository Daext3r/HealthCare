$(document).ready(function () {
   //mostramos la cantidad de notificaciones
   $("#notificaciones").text(localStorage.getItem("notificaciones"));

   $.post(localStorage.getItem("hc_base_url") + "Tratamientos_controller/leerTratamientos", {}, function (data) {
      data = JSON.parse(data);

      //si no hay datos, mostramos un mensaje de informacion y paramos la ejecucion
      if (data.length == 0) {
         $("#lista").append("<h3>No tienes tratamientos activos, ¡Genial!</h3>");
      };

      //borramos el contenido del cuerpo
      $("#tratamientos").html("");

      for (let tratamiento of data) {
         //primero leemos el nombre del medicamento
        fetch(`https://cima.aemps.es/cima/rest/medicamento?nregistro=${tratamiento.nregistro}`)
            .then((respuesta) => {
               //convertimos la respuesta en un objeto literal json
               return respuesta.json();
            })
            .then((respuesta) => {
               //creamos un elemento div y lo configuramos
               let caja = document.createElement("div");
               caja.classList.add('card');
               caja.classList.add("bg-light");
               caja.classList.add("mb-3");

               let cuerpo = document.createElement("div");
               cuerpo.classList.add("card-body");
               caja.appendChild(cuerpo);

               let img = document.createElement("img");

               //no todos los medicamentos tienen fotos
               if (respuesta.fotos) {
                  //la primera foto es la foto de la caja, siempre
                  img.src = respuesta.fotos[0].url;
               } else {
                  img.src = localStorage.getItem("hc_base_url") + "assets/img/NoImagenMedicamento.png";
               }

               cuerpo.appendChild(img);

               let header = document.createElement("div");
               header.classList.add("card-header");
               header.innerText = respuesta.nombre;
               caja.appendChild(header);

               //forzamos a que tenga un ancho maximo
               caja.style = "max-width: 20%;max-height:45%;";

               $(caja).appendTo("#lista");




               /**
                *  <div class="card bg-light mb-3" style="max-width: 18rem;">
                                <div class="card-body">
                                   <img src="https://cima.aemps.es/cima/fotos/thumbnails/materialas/51347/51347_materialas.jpg" srcset="">
                                </div>
                                <div class="card-header">Toujeo 300 unidades/ml SoloStar, solución inyectable en pluma precargada</div>
                             </div>
               
                */
               let dosis = JSON.parse(tratamiento.dosis);

               let contenidoModal = "";
               contenidoModal += `<p>Fecha de inicio del tratamiento ${new Date(tratamiento.fecha_inicio).toLocaleDateString()}</p><br>`;
               contenidoModal += `<p>Fecha de fin del tratamiento ${new Date(tratamiento.fecha_fin).toLocaleDateString()}</p><br>`;
               contenidoModal += `<p>Dosis: ${dosis.dosis} ${dosis.presentacion} en las siguientes horas:</p>`;

               contenidoModal += "<ul class='ul-modal'>";
               for (let hora of dosis.horas) {
                  contenidoModal += `<li class='li-modal'>${hora}</li>`;
               }
               contenidoModal += "</ul>";

               //VENTANA POPUP
               $(caja).on("click", function (e) {
                  e.preventDefault();
                  Swal.fire({
                     title: 'Tratamiento',
                     html: contenidoModal,
                     showCloseButton: true,
                     showCancelButton: false,
                     focusConfirm: true,
                     confirmButtonText: "Cerrar",

                     cancelButtonAriaLabel: 'Thumbs down'
                  })
               })
            });
      }
   })
});