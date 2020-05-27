<!--Es necesario poner un height aqui para que una libreria no cambie el height del body-->

<?php
//vamos a comprobar si existe la imagen de perfil
$imgPerfil;
if (count(glob($this->config->item("local_profile_path") . $this->session->userdata("ciu") . ".*")) >= 1) {
   $formato = glob($this->config->item("local_profile_path") . $this->session->userdata("ciu") . ".*");
   $formato = explode(".", $formato[0])[1];

   $imgPerfil = $this->config->item("online_profile_path") . $this->session->userdata("ciu") . "." . $formato;
} else {
   $imgPerfil = "https://www.jennstrends.com/wp-content/uploads/2013/10/bad-profile-pic-2-768x768.jpeg";
}
?>

<body style="height: 100vh!important">
   <!--seccion del menu lateral-->
   <section id="menu">
      <div id="perfil">
         <div id="imgperfil">
            <img src="<?php echo $imgPerfil ?> " alt="">
         </div>

         <div id="panel-nombre">
            <?php echo $this->session->userdata("nombre") . " " . $this->session->userdata("apellidos") ?>
         </div>

         <div class="separador"></div>
      </div>

      <div id="secciones">
         <?php
         //miramos el tipo del usuario
         switch ($this->session->userdata('tipo')) {
               //si es paciente...
            case 'paciente':
         ?>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>paciente/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>paciente/citas">
                  <div class="list-group-item">Citas</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>paciente/tratamientos">
                  <div class="list-group-item">Tratamientos</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>paciente/informes">
                  <div class="list-group-item">Informes</div>
               </a>
               <div class="separador w-100"></div>

            <?php
               break;
               //si es admin...
            case 'admin':
            ?>
               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>admin/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Usuarios <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>admin/crear/usuario" class="nested">
                        <div class="list-group-item">Crear usuario</div>
                     </a>

                     <div class="separador w-100"></div>

                     <a href="<?php echo base_url() ?>admin/administrar/usuario" class="nested">
                        <div class="list-group-item">Datos de usuario</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Centros <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>admin/crear/centro" class="nested">
                        <div class="list-group-item">Crear centro</div>
                     </a>

                     <div class="separador w-100"></div>

                     <a href="<?php echo base_url() ?>admin/administrar/centro" class="nested">
                        <div class="list-group-item">Administrar centro</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Perfiles <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>admin/crear/paciente" class="nested">
                        <div class="list-group-item">Crear paciente</div>
                     </a>

                     <div class="separador w-100"></div>

                     <a href="<?php echo base_url() ?>admin/crear/facultativo" class="nested">
                        <div class="list-group-item">Crear facultativo</div>
                     </a>
                  </div>
               </div>


               <div class="separador w-100"></div>
            <?php
               break;
               //si es gerente...
            case 'gerente':
            ?>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>gerente/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>gerente/crearUsuario">
                  <div class="list-group-item">Crear usuario</div>
               </a>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Perfiles <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>gerente/nuevo/paciente">
                        <div class="list-group-item">Nuevo paciente</div>
                     </a>
                     <div class="separador w-100"></div>
                     <a href="<?php echo base_url() ?>gerente/nuevo/facultativo">
                        <div class="list-group-item">Nuevo facultativo</div>
                     </a>
                     <a href="<?php echo base_url() ?>gerente/nuevo/laboratorio">
                        <div class="list-group-item">Nuevo personal de lab.</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>gerente/gestionarAdministrativos">
                  <div class="list-group-item">Gestionar administrativos</div>
               </a>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Traslados <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>gerente/traslados/nuevo" class="nested">
                        <div class="list-group-item">Nuevo traslado</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>gerente/traslados/solicitudes" class="nested">
                        <div class="list-group-item">Solicitudes de traslados</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>
            <?php
               break;
               //si es facultativo...
            case 'facultativo':
            ?>
               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>facultativo/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>

               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>facultativo/episodios">
                  <div class="list-group-item">Episodios</div>
               </a>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Tratamientos <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>facultativo/tratamientos/nuevo" class="nested">
                        <div class="list-group-item opcion">Nuevo trat.</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>facultativo/tratamientos/ver" class="nested">
                        <div class="list-group-item opcion">Ver tratamientos</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Citas <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>facultativo/citas/ver" class="nested">
                        <div class="list-group-item opcion">Citas</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>facultativo/citas/derivar" class="nested">
                        <div class="list-group-item opcion">Derivación</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Informes <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>facultativo/informes/nuevo" class="nested">
                        <div class="list-group-item opcion">Nuevo Informe</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>facultativo/informes/historial" class="nested">
                        <div class="list-group-item opcion">Hist. Informes</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Analíticas <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>facultativo/analiticas/nueva" class="nested">
                        <div class="list-group-item opcion">Nueva Analítica</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>facultativo/analiticas/historial" class="nested">
                        <div class="list-group-item opcion">Hist. Analíticas</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>facultativo/enfermedades">
                  <div class="list-group-item">Enfermedades</div>
               </a>

               <div class="separador w-100"></div>
            <?php
               break;
            case 'administrativo':
            ?>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>administrativo/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Usuarios <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>administrativo/usuario/nuevo" class="nested">
                        <div class="list-group-item">Crear usuario</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>administrativo/usuario/modificar" class="nested">
                        <div class="list-group-item opcion">Admin. usuario</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Perfiles <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>administrativo/nuevo/facultativo" class="nested">
                        <div class="list-group-item">Nuevo facultativo</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>administrativo/nuevo/laboratorio" class="nested">
                        <div class="list-group-item">Nuevo Técnico Lab.</div>
                     </a>
                     <div class="separador"></div>
                     <a href="<?php echo base_url() ?>administrativo/nuevo/paciente" class="nested">
                        <div class="list-group-item">Nuevo paciente</div>
                     </a>
                  </div>
               </div>

               <div class="separador w-100"></div>

               <div class="group list-group-item">
                  <div class="title">
                     Citas <i class="fas fa-arrow-down"></i>
                  </div>
                  <div class="content">
                     <a href="<?php echo base_url() ?>administrativo/citas/nueva" class="nested">
                        <div class="list-group-item">Nueva cita</div>
                     </a>
                     <div class="separador"></div>
                     <!-- TODO EN V2
                     <a href="<?php echo base_url() ?>administrativo/citas/ver" class="nested">
                        <div class="list-group-item opcion">Ver citas</div>
                     </a>-->
                  </div>
               </div>

               <div class="separador w-100"></div>
            <?php
               break;
            case 'laboratorio':
            ?>
               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>laboratorio/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>

               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>laboratorio/analiticas/atender">
                  <div class="list-group-item">Atender analíticas</div>
               </a>

               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>laboratorio/analiticas/atendidas">
                  <div class="list-group-item">Analíticas atendidas</div>
               </a>

               <div class="separador w-100"></div>

               <a href="<?php echo base_url() ?>laboratorio/analiticas/historial">
                  <div class="list-group-item">Historial analíticas</div>
               </a>

               <div class="separador w-100"></div>
         <?php
               break;
         }
         ?>
      </div>
   </section>

   <!--seccion del contenido-->
   <div id="pagina">
      <nav id="header">
         <div class="col perfil wsnw">
            <div data-toggle="modal" data-target="#modificarDatos">Mi perfil <i class="fas fa-cog"></i></div>
         </div>

         <div class="separador-v"></div>

         <div class="col reloj wsnw">
            <div class="" id="reloj"></div>
         </div>

         <div class="separador-v"></div>

         <div class="col notificaciones">
            <div class="dropdown">
               <div class="dropbtn wsnw hover" id="notificaciones-text">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones</div>
               <div class="dropdown-content" id="listaNotificaciones"></div>
            </div>
         </div>

         <div class="separador-v"></div>

         <div class="col logout">
            <div id="logout">
               <i class="fas fa-sign-out-alt"></i>
               <span>Salir</span>
            </div>
         </div>
      </nav>

      <!-- Modal -->
      <div class="modal fade" id="modificarDatos" tabindex="-1" role="dialog" aaria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Modificar datos</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">

                  <form method="post" class="datos">
                     <div class="row datos-row">
                        <div class="col datos-col">
                           <label for="fijo">Fijo</label>
                           <input type="text" name="Fijo" class="form-control" placeholder="Fijo" autocomplete="off" required value="<?php echo $this->session->userdata("fijo") ?>" id="perf-fijo">
                        </div>
                        <div class="col datos-col">
                           <label for="telefono">Telefono</label>
                           <input type="text" name="telefono" class="form-control" placeholder="Telefono" autocomplete="off" required value="<?php echo $this->session->userdata("telefono") ?>" id="perf-telefono">
                        </div>
                     </div>

                     <div class="row datos-row">
                        <div class="col datos-col">
                           <label for="direccion">Direccion</label>
                           <input type="text" name="direccion" id="perf-direccion" class="form-control" placeholder="Direccion" autocomplete="off" required value="<?php echo $this->session->userdata("direccion") ?>">
                        </div>
                        <div class="col datos-col">
                           <label for="correo">Correo electrónico</label>
                           <input type="mail" class="form-control" name="correo" placeholder="Correo" autocomplete="off" required value="<?php echo $this->session->userdata("correo") ?>" id="perf-correo">
                        </div>
                     </div>

                     <div class="row">
                        <div class="col">
                           <label for="imagenPerfil">Cambiar imagen de perfil</label>
                           <input type="file" accept="image/png, image/jpeg" id="imagenPerfil">
                        </div>
                        <div class="col">
                           <label for=""></label>
                           <button class="btn btn-outline-primary w-100 d-block" id="cambiarClave">Cambiar contraseña</button>
                        </div>
                        <div class="col">
                           <label for=""></label>
                           <button class="btn btn-success w-100 d-block" id="modificarDatosGuardar">Guardar cambios</button>
                        </div>
                     </div>
                  </form>

               </div>
            </div>
         </div>
      </div>