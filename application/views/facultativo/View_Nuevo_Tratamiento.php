<section class="contenido" style="display: none;">
   <!--Lista de pacientes que está atendiendo-->
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>

   <div class="tratamientos">
      <div class="row">
         <div class="col">
            <label for="fecha_inicio">Inicio del tratamiento</label>
            <input type="date" class="form-control" id="fecha_inicio">
         </div>
         <div class="col">
            <label for="fecha_fin">Inicio del tratamiento</label>
            <input type="date" class="form-control" id="fecha_fin">
         </div>
      </div>

      <div class="row">
         <div class="col">
            <label for="episodio">Episodio</label>
            <select id="episodio" class="form-control">
            </select>
         </div>
         <div class="col">
            <label class="w-100">Número de Medicación | <a href="http://cima.aemps.es/cima/publico/home.html" target="_blank">Buscador</a></label>
            <input type="text" class="form-control" placeholder="Número de registro" id="nregistro">
         </div>
      </div>

      <div class="row tomas" id="tomas">
         <button class="btn btn-outline-primary d-block w-50 mx-auto" id="nuevaToma">Nueva toma</button>
      </div>
      <div class="row"><button class="btn btn-outline-success d-block w-50 mx-auto" id="guardarTratamiento">Guardar tratamiento</button></div>
   </div>


</section>
</div>

<!--MODAL PARA BUSCAR UN PACIENTE-->
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
            <input type="list" id="usuario" list="usuarios" placeholder="Nombre o CIU" class="form-control" autocomplete="off" autofocus>
            <datalist id="usuarios">
            </datalist>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
</body>