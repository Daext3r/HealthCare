<section class="contenido" style="display: none;">
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>

   <div class="filtro">
      <div class="col">
         <label for="especialidad">Especialidad</label>
         <select id="especialidad" class="form-control">
            <option value="todas" selected>Todas</option>
         </select>
      </div>
      <div class="col">
         <label for="episodio">Episodio</label>
         <select id="episodio" class="form-control">
            <option value="todos" selected>Todos</option>
         </select>
      </div>
      <div class="col">
         <label for="desde">Desde</label>
         <input type="date" id="desde" class="form-control">
      </div>
      <div class="col">
         <label for="hasta">Hasta</label>
         <input type="date" id="hasta" class="form-control">
      </div>
      <div class="col">
         <label for="reset">Borar filtros</label><br>
         <button id="reset" class="btn btn-primary w-100">Borrar</button>
      </div>
   </div>
   <hr>
   <div class="lista" id="lista"></div>
</section>
</div>
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
</body>