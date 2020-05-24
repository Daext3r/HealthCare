$(document).ready(() => {
   //primero ponemos el ciu del paciente en el campo de paciente
   let paciente = JSON.parse(localStorage.getItem("hc_lista_pacientes")).filter(p => p.seleccionado == true)[0];

   //si hay un paciente seleccionado lo ponemos en el input y cargamos los episodios
   if (paciente) {
      cargarEpisodios(paciente.CIU);
   }

   //si cambiamos de paciente seleccionado, tambien lo hacemos en el formulario
   document.getElementById("pacientes").addEventListener("cambioPaciente", (e) => {
      $("#pacienteInforme").val(e.detail.CIU);
      cargarEpisodios(e.detail.CIU);
   });


   $("#nuevaToma").click(agregarToma);

   $("#guardarTratamiento").click(() => {
      //guardamos los datos basicos
      let inicio = $("#fecha_inicio").val();
      let fin = $("#fecha_fin").val();
      let episodio = $("#episodio").val();
      let nregistro = $("#nregistro").val();
      let tomas = [];
      let paciente;
      
      if($("div.paciente.seleccionado")[0]) {
         paciente = $("div.paciente.seleccionado")[0].dataset.CIU;
      } else {
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No puedes crear un tratamiento sin atender a un paciente antes'
         });
         return;
      }
      //guardamos los divs que contienen las dosis
      let divs = $(".toma");
      for (let hijo of divs) {
         let toma = {};
         toma.hora = hijo.children[0].children[1].value;
         toma.dosis = hijo.children[1].children[1].children[0].value;
         tomas.push(toma);
      }

      $.post(localStorage.getItem("hc_base_url") + "Tratamientos_controller/agregarTratamiento", {paciente: paciente, fecha_inicio: inicio, fecha_fin: fin, episodio: episodio, tomas: JSON.stringify(tomas), nregistro : nregistro}, (data) => {
         console.log(data);
         if (data == 1) {
            Swal.fire({
               icon: 'success',
               title: 'Hecho',
               text: 'Se ha creado el tratamiento'
            })
         }
      })
   });
})

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
function quitarToma(elem) {
   elem.parentNode.parentNode.remove();
}
function agregarToma() {
   let toma = $(`
   <div class="alert alert-secondary w-75 mx-auto toma row">
   <div class="col">
      <label for="hora">Hora</label>
      <select class="form-control">
         <option value="0">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
         <option value="7">7</option>
         <option value="8">8</option>
         <option value="9">9</option>
         <option value="10">10</option>
         <option value="11">11</option>
         <option value="12">12</option>
         <option value="13">13</option>
         <option value="14">14</option>
         <option value="15">15</option>
         <option value="16">16</option>
         <option value="17">17</option>
         <option value="18">18</option>
         <option value="19">19</option>
         <option value="20">20</option>
         <option value="21">21</option>
         <option value="22">22</option>
         <option value="23">23</option>
      </select>
   </div>
   <div class="col">
      <label for="cantidad">Cantidad</label>
      <div class="input-group mb-3">
         <input type="text" class="form-control" placeholder="Cantidad">
         <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">unidades</span>
         </div>
      </div>
   </div>
   <div class="col col-1">
      <button class="btn btn-danger" onclick="quitarToma(this)">&times;</button>
   </div>
</div>
`);

   $("#tomas").append($(toma));
}