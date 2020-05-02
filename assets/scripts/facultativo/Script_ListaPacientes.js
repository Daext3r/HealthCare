/**
 * 
    <!--Lista de pacientes que está atendiendo-->
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>


      <!-- Modal -->
<div class="modal fade" id="modal-buscar-paciente" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Buscar a un paciente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="list" id="usuario" list="usuarios" placeholder="Nombre o CIU" class="form-control" autocomplete="off">
            <datalist id="usuarios">
            </datalist>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

         </div>
      </div>
   </div>
</div>
 */


function agregarPaciente(paciente) {
   let div = document.createElement("div");
   div.classList.add("paciente");
   div.dataset.CIU = paciente.CIU;

   if (paciente.seleccionado == true) div.classList.add("seleccionado");

   let nombre = document.createElement("span");
   nombre.classList.add("nombre");
   nombre.innerText = paciente.nombre_completo;

   let fade = document.createElement("span");
   fade.classList.add("myfade");

   div.appendChild(nombre);
   div.appendChild(fade);

   $("#pacientes").append($(div));
}

$(document).ready(() => {
   //cuando se cargue el documento, leemos los pacientes que hay en localstorage
   const pacientes = JSON.parse(localStorage.getItem("hc_lista_pacientes"));

   //por cada paciente, creamos un elemento en la barra de pacientes
   if (pacientes != null)
      for (let paciente of pacientes) {
         agregarPaciente(paciente);
      }


   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#usuario").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#usuarios").html("");

      //si el input esta vacio, no busca nada
      if ($("#usuario").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $("#usuario").val() }, (data) => {
            data = JSON.parse(data);
            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#usuarios").append($(option));
            }
         });
      }, 700);
   });

   $("#usuario").change(function () {
      //cuando se seleccione un usuario, buscamos los datos de ese usuario
      $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $(this).val() }, (data) => {
         data = JSON.parse(data);
         data[0].seleccionado = false;

         //declaramos la variable de pacientes. Si hay pacientes en localstorage los añadimos a la variable
         let pacientes = [];
         if (localStorage.getItem("hc_lista_pacientes") != null) {
            for (let paciente of JSON.parse(localStorage.getItem("hc_lista_pacientes"))) {
               pacientes.push(paciente);
            }
         }

         //añadimos el nuevo paciente a localstorage
         pacientes.push(data[0]);

         //añadimos el nuevo paciente a pantalla 
         agregarPaciente(data[0]);

         //cerramos la ventana modal
         $("#modal-buscar-paciente").modal('toggle');

         //borramos el contenido del cuadro de busqueda
         $(this).val("");

         //guardamos en localstorage la nueva variable
         //en este punto pacientes tendra minimo un registro, asi que no hace falta hacer comprobaciones

         localStorage.setItem("hc_lista_pacientes", JSON.stringify(pacientes));
      });
   });
});