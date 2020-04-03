<section class="contenido">
   <form methos="POST" id="form">

      <div class="form-row">
         <h4>Registrar un nuevo centro en el sistema</h4>
         <h5 class="text-muted">Recuerda crear primero el usuario del gerente si aún no lo has hecho</h5>
      </div>


      <div class="form-row">
         <div class="col custom-col">
            <label for="nombre">Nombre del centro</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Denominación" required>
         </div>
         <div class="col custom-col">
            <label for="direccion">Dirección del centro</label>
            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" required>
         </div>
      </div>

      <div class="form-row">
         <div class="col custom-col">
            <label for="telefonos">Números de teléfono <small>(separados por coma)</small></label>
            <input type="text" class="telefonos form-control" placeholder="Telefonos">
         </div>
         <div class="col custom-col">
            <label for="gerente">Gerente</label>
            <input list="gerentes" name="CIU_gerente" class="form-control" id="gerente" placeholder="CIU" autocomplete="off" required>
            <datalist id="gerentes"></datalist>
         </div>
      </div>

      <div class="form-row">
         <div class="telefonos"></div>
      </div>

      <div class="form-row">
         <div class="col custom-col">
            <label for="hora_apertura">Hora de apertura</label>
            <select name="hora_apertura" id="hora_apertura" class="form-control" required>
               <?php
               for ($i = 6; $i <= 23; $i++) {
                  echo "<option value='$i'>$i</option>";
               }
               ?>
            </select>
         </div>
         <div class="col custom-col">
            <label for="hora_cierre">Hora de cierre</label>
            <select name="hora_cierre" id="hora_cierre" class="form-control" required>
               <?php
               for ($i = 6; $i <= 23; $i++) {
                  echo "<option value='$i'>$i</option>";
               }
               ?>
            </select>
         </div>
      </div>

      <input type="submit" value="Crear centro" class="btn btn-success w-75 custom-submit">
   </form>
</section>