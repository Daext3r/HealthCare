/**
 * 
 * ELEMENTOS A AÑADIR EN PAGINAS PARA USAR ESTE SCRIPT
    <!--Lista de pacientes que está atendiendo-->
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>


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


   let x = document.createElement("span");
   x.classList.add("quitar");
   x.innerHTML = "&times;";

   x.addEventListener("click", () => {
      //quitamos el div del dom
      div.remove();

      //quitamos el paciente de localstorage
      localStorage.setItem("hc_lista_pacientes", JSON.stringify(JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(pacienteLista => pacienteLista.CIU != paciente.CIU)));
   });

   fade.appendChild(x);

   div.appendChild(nombre);
   div.appendChild(fade);
   div.addEventListener("click", (e) => seleccionarPaciente(e));

   $("#pacientes").append($(div));
}

function seleccionarPaciente(e) {
   //si hacemos click en otro sitio que no sea en el fade (por ejemplo, la cruz de quitar) cancelamos el evento;
   if (!e.target.classList.contains("myfade")) return;

   //buscamos el elemento que está seleccionado actualmente
   let seleccionado = document.getElementsByClassName("seleccionado")[0];

   let nuevoSeleccionado = e.target.parentNode;
   //le quitamos la clase de seleccionado y se la ponemos al nuevo seleccionado
   seleccionado.classList.remove("seleccionado");
   nuevoSeleccionado.classList.add("seleccionado");

   //cambiamos los datos en localstorage
   let pacientes = JSON.parse(localStorage.getItem("hc_lista_pacientes"));
   pacientes.filter(paciente => paciente.CIU == seleccionado.dataset.CIU)[0].seleccionado = false;
   pacientes.filter(paciente => paciente.CIU == nuevoSeleccionado.dataset.CIU)[0].seleccionado = true;

   //guardamos los datos en localstorage
   localStorage.setItem("hc_lista_pacientes", JSON.stringify(pacientes));
   
   //si todo se ha ejecutado, disparamos un evento PROPIO que nos servirá en otras partes de la aplicacion
   //lo disparamos al contenedor de todos los pacientes
   document.getElementById("pacientes").dispatchEvent(new CustomEvent('cambioPaciente', { 'detail' : {'CIU': nuevoSeleccionado.dataset.CIU, 'nombre' : nuevoSeleccionado.children[0].innerText }}));

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
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiuNombre", { dato: $("#usuario").val() }, (data) => {
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

         //comprobamos si es el primer paciente. si lo es, lo marcamos como seleccionado
         if (JSON.parse(localStorage.getItem("hc_lista_pacientes")) == null || JSON.parse(localStorage.getItem("hc_lista_pacientes")).length == 0) data[0].seleccionado = true;

         //comprobamos si el paciente ya existe en localstorage. si existe, no lo añadimos
         for (let paciente of pacientes) {
            if (paciente.CIU == data[0].CIU) {
               //cerramos modal y no hacemos nada mas
               $("#modal-buscar-paciente").modal('toggle');
               return;
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