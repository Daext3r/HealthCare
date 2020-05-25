<section class="contenido" style="display: none;">
   <nav id="pacientes">
      <div class="agregarPaciente" title="Buscar paciente" data-toggle="modal" data-target="#modal-buscar-paciente">
         <i class="fas fa-plus"></i>
      </div>
   </nav>
   <div class="cabecera">
      <div class="col">
         <label for="pacienteInforme">Paciente:</label>
         <input type="text" id="pacienteInforme" disabled class="form-control">
      </div>

      <div class="col">
         <label for="episodio">Episodio</label>
         <select name="episodio" id="episodio" class="form-control">
            <option value="NULL">Ninguno</option>
         </select>
      </div>

      <div class="col">
         <label for="guardar">Guardar informe</label>
         <button id="guardar" class="btn btn-success">Guardar</button>
      </div>

      <div class="col">
         <label for="privado">Informe privado</label>
         <button id="privado" class="btn btn-success" data-privado="false"><i class="fas fa-unlock"></i></button>
      </div>
   </div>
   <div id="contenidoInforme" contenteditable>

   </div>

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