<section class="contenido" style="display: none">
   <div class="my-row row" id="buscador">
      <div class="my-col col">
         <label for="centro">Centro</label>
         <div class="input-group mb-2 mr-sm-2">
            <input list="centros" class="form-control" id="centro" placeholder="Nombre" autocomplete="off" required>
            <datalist id="centros"></datalist>
            <div class="input-group-prepend">
               <div class="input-group-text"><i class="fas fa-search"></i></div>
            </div>
         </div>
      </div>
      <h4>Busca un centro y selecciónalo</h4>
   </div>


   <form method="post" class="datos" style="display: none;" id="form">
      <input type="hidden" name="id" id="id">
      <h4>Editar datos de un centro</h4>
      <div class="row datos-row">
         <div class="col datos-col">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre">
         </div>
         <div class="col datos-col">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion">
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="nacionalidad">Hora de apertura</label>
            <input type="text" id="hora_apertura" name="hora_apertura" class="form-control" placeholder="Hora de apertura" autocomplete="off" required>
         </div>
         <div class="col datos-col">
            <label for="fecha_nacimiento">Hora de cierre</label>
            <input type="text" class="form-control" id="hora_cierre" name="hora_cierre" placeholder="Hora de cierre" autocomplete="off" required>
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="correo">Telefonos <small>(separados por comas)</small></label>
            <input type="text" id="telefonos" class="form-control telefonos" placeholder="Telefonos" autocomplete="off">
         </div>
      </div>

      <div class="row datos-row">
         <div class="telefonos"></div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="CIU_gerente">Gerente</label>
            <div class="input-group mb-2 mr-sm-2">
               <input list="gerentes" id="CIU_gerente" class="form-control" name="CIU_gerente" placeholder="Gerente" autocomplete="off" required>
               <datalist id="gerentes"></datalist>
               <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-search"></i></div>
               </div>
            </div>
         </div>
      </div>

      <input type="submit" value="Actualizar datos del centro" class="btn btn-success w-75 datos-submit" id="enviar">
   </form>
</section>
</div>
</body>