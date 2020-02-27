        <section id="misdatos-contenido">
            <form action="<?php echo base_url(); ?>controllers/paciente/actualizarDatos" method="POST">
                <div class="form-row">
                    <div class="col misdatos-col">
                        <label for="ciu">Código de identificación</label>
                        <input type="text" class="form-control" placeholder="CIU" id="ciu" value="<?php echo $this->session->userdata("ciu") ?>" readonly>
                    </div>
                    <div class="col misdatos-col">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $this->session->userdata("nombre") ?>" readonly>
                    </div>
                </div>

                <div class="form-row">

                    <div class="col misdatos-col">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input type="text"id="nacionalidad" class="form-control" placeholder="Nacionalidad" value="<?php echo $this->session->userdata("nacionalidad") ?>" readonly>
                    </div>
                    <div class="col misdatos-col">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" value="<?php echo $this->session->userdata("apellidos") ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col misdatos-col">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" placeholder="Apellidos" value="<?php echo $this->session->userdata("dni") ?>" readonly>
                    </div>
                    <div class="col misdatos-col">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" class="form-control"id="fecha_nacimiento" value="<?php echo $this->session->userdata("fecha_nacimiento") ?>" readonly>
                    </div>
                </div>

                <h5 class="misdatos-h5">Los datos de la parte superior deben ser modificados por un administrativo en su centro de salud</h5>

                <div class="form-row">
                    <div class="col misdatos-col">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" value="<?php echo $this->session->userdata("correo") ?>">
                    </div>
                    <div class="col misdatos-col">

                        <label for="clave">Clave</label>
                        <button type="button" class="btn btn-primary w-100" id="cambiarClave">Cambiar clave</button>
                        <input type="hidden" name="clave" id="clave">
                    </div>

                </div>
                <div class="form-row">
                    <div class="col misdatos-col">
                        <label for="nacionalidad">Teléfono móvil</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="T. Móvil" value="<?php echo $this->session->userdata("telefono") ?>">
                    </div>
                    <div class="col misdatos-col">
                        <label for="dni">Teléfono fijo</label>
                        <input type="text" class="form-control" name="fijo" id="fijo" placeholder="T. Fijo" value="<?php echo $this->session->userdata("fijo") ?>" pattern="[0-9]">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 misdatos-col">
                        <label for="direccion">Direccion</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $this->session->userdata("direccion") ?>">
                    </div>
                </div>
                <input type="submit" value="Guardar cambios" class="btn btn-success w-100 misdatos-submit">
            </form>

        </section>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        </body>