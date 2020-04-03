<section class="contenido">
   <div class="my-row row" id="buscador">
      <div class="my-col col">

         <label for="usuario">Usuario</label>
         <div class="input-group mb-2 mr-sm-2">
            <input list="usuarios" class="form-control" id="usuario" placeholder="CIU" autocomplete="off" required>
            <datalist id="usuarios"></datalist>
            <div class="input-group-prepend">
               <div class="input-group-text" id="letraDni"><i class="fas fa-search"></i></div>
            </div>
         </div>




      </div>
      <h4>Busca un usuario y selecciónalo</h4>
   </div>

   <form method="post" class="datos" style="display: none;">
      <h4>Editar datos de un usuario</h4>
      <div class="row datos-row">
         <div class="col datos-col">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control">
         </div>
         <div class="col datos-col">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control">
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="dni">DNI <small>8 dígitos sin letra</small></label>
            <div class="input-group mb-2 mr-sm-2">
               <input type="number" class="form-control" id="dni" name="dni" placeholder="DNI" autocomplete="off" required maxlength="8">
               <div class="input-group-prepend">
                  <div class="input-group-text" id="letraDni">-</div>
               </div>
            </div>
         </div>

         <div class="col datos-col">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo" class="form-control" required>
               <option value="H">Hombre</option>
               <option value="M">Mujer</option>
            </select>
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="nacionalidad">Nacionalidad</label>
            <input type="text" id="nacionalidad" name="nacionalidad" class="form-control" placeholder="Nacionalidad" autocomplete="off" required>
         </div>
         <div class="col datos-col">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" autocomplete="off" required>
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" autocomplete="off" required>
         </div>
         <div class="col datos-col">
            <label for="direccion">Direccion</label>
            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" autocomplete="off" required>
         </div>
      </div>

      <div class="row datos-row">
         <div class="col datos-col">
            <label for="nacionalidad">Teléfono móvil</label>
            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="T. Móvil" autocomplete="off" required>
         </div>
         <div class="col datos-col">
            <label for="dni">Teléfono fijo</label>
            <input type="text" class="form-control" name="fijo" id="fijo" placeholder="T. Fijo" autocomplete="off" required>
         </div>
      </div>

      <input type="submit" value="Actualizar datos de usuario" class="btn btn-success w-75 datos-submit">
   </form>
</section>