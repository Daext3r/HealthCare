<section class="contenido" style="display: none;">
   <!--Lista de pacientes que está atendiendo-->
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>
   <button class="btn btn-outline-primary w-50 nuevo" id="nuevoEpisodio" data-toggle="modal" data-target="#modal-nuevo-episodio">Nuevo episodio</button>
   <section id="episodios"></section>
</section>
</div>
<!-- Modal añadir paciente-->
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

<!-- Modal nuevo episodio -->
<div class="modal fade" id="modal-nuevo-episodio" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Crear un episodio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!--Especialidad y descripcion-->
            <textarea class="form-control mb-2" placeholder="Una descripción del episodio..." id="descripcion"></textarea>

            <input type="list" id="especialidad" list="especialidades" placeholder="Especialidad" class="form-control" autocomplete="off">
            <datalist id="especialidades"></datalist>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="crearEpisodio">Crear</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
</body>