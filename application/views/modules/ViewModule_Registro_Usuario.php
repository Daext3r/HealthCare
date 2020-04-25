        <section class="contenido">
           <?php
            switch ($this->session->flashdata("info")) {
               case "error":
            ?>
                 <div class="alert alert-danger w-75" role="alert">
                    Ha ocurrido un error. Revise los datos introducidos
                 </div>
              <?php
                  break;
               case "ok":
               ?>
                 <div class="alert alert-success w-75" role="alert">
                    Se registrado al usuario correctamente
                 </div>
           <?php
                  break;
            }
            ?>

           <form action="#" method="POST" id="form">
              <div class="form-row">
                 <h4>Registrar un nuevo usuario en el sistema</h4>
              </div>
              <div class="form-row">
                 <div class="col custom-col">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" autocomplete="off" required>
                 </div>
                 <div class="col custom-col">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" autocomplete="off" required>
                 </div>
              </div>

              <div class="form-row">
                 <div class="col custom-col">
                    <label for="nacionalidad">Nacionalidad</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" class="form-control" placeholder="Nacionalidad" autocomplete="off" required>
                 </div>

                 <div class="col custom-col">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" class="form-control" required>
                       <option value="H">Hombre</option>
                       <option value="M">Mujer</option>
                    </select>
                 </div>
              </div>

              <div class="form-row">
                 <div class="col custom-col">
                    <label for="dni">DNI <small>8 dígitos sin letra</small></label>
                    <div class="input-group mb-2 mr-sm-2">
                       <input type="number" class="form-control" id="dni" name="dni" placeholder="DNI" autocomplete="off" required maxlength="8">
                       <div class="input-group-prepend">
                          <div class="input-group-text" id="letraDni">-</div>
                       </div>
                    </div>
                 </div>
                 <div class="col custom-col">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" autocomplete="off" required>
                 </div>
              </div>

              <div class="form-row">
                 <div class="col custom-col">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" autocomplete="off" required>
                 </div>
                 <div class="col custom-col">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" autocomplete="off" required>
                 </div>
              </div>

              <div class="form-row">
                 <div class="col custom-col">
                    <label for="nacionalidad">Teléfono móvil</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="T. Móvil" autocomplete="off" required>
                 </div>
                 <div class="col custom-col">
                    <label for="dni">Teléfono fijo</label>
                    <input type="text" class="form-control" name="fijo" id="fijo" placeholder="T. Fijo" autocomplete="off" required>
                 </div>
              </div>

              
                 <input type="submit" value="Registrar usuario" class="btn btn-success w-75 custom-submit">
              

           </form>

        </section>
        </div>
        </body>
        