<section class="contenido" style="display: none;">
   <!--Lista de pacientes que está atendiendo-->
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>

   <div class="enfermedades">
      <button class="btn btn-outline-primary w-75 d-block m-auto" id="nuevaEnfermedad">Añadir Enfermedad</button>
      <div class="listaEnfermedades">
         <div class="enfermedad row alert alert-secondary">
            <div class="col d-flex align-items-center">
               asddassdaasdadsdasdasd
            </div>
            <div class="col-1">
               <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </div>
         </div>
      </div>
   </div>
</section>
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