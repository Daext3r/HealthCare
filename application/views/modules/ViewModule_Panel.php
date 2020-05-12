<!--Es necesario poner un height aqui para que una libreria no cambie el height del body-->

<body style="height: 100vh!important">
   <!--seccion del menu lateral-->
   <section id="menu">
      <div id="perfil">
         <div id="imgperfil">
            <img src="https://www.jennstrends.com/wp-content/uploads/2013/10/bad-profile-pic-2-768x768.jpeg" alt="">
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
               <a href="<?php echo base_url() ?>paciente/inicio">
                  <div class="list-group-item">Inicio</div>
               </a>
               <a href="<?php echo base_url() ?>paciente/citas">
                  <div class="list-group-item">Citas</div>
               </a>
               <a href="<?php echo base_url() ?>paciente/tratamientos">
                  <div class="list-group-item">Tratamientos</div>
               </a>
               <a href="<?php echo base_url() ?>paciente/informes">
                  <div class="list-group-item">Informes</div>
               </a>
               <!--<a href="<?php //echo base_url() 
                              ?>paciente/misdatos">
                     <li class="list-group-item last">Mis Datos</div>
                  </a>-->
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
               <a href="<?php echo base_url() ?>admin/crear/usuario">
                  <div class="list-group-item">Crear usuario</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>admin/crear/centro">
                  <div class="list-group-item">Crear centro</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>admin/crear/paciente">
                  <div class="list-group-item">Crear paciente</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>admin/crear/facultativo">
                  <div class="list-group-item">Crear facultativo</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>admin/administrar/usuario">
                  <div class="list-group-item">Datos de usuario</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>admin/administrar/centro">
                  <div class="list-group-item">Administrar centro</div>
               </a>
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
               <a href="<?php echo base_url() ?>gerente/nuevo/paciente">
                  <div class="list-group-item">Nuevo paciente</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>gerente/nuevo/facultativo">
                  <div class="list-group-item">Nuevo facultativo</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>gerente/gestionarAdministrativos">
                  <div class="list-group-item">Gestionar administrativos</div>
               </a>
               <div class="separador w-100"></div>
               <a href="<?php echo base_url() ?>gerente/traslados">
                  <div class="list-group-item">Traslados</div>
               </a>
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

               <a href="<?php echo base_url() ?>facultativo/tratamientos">
                  <div class="list-group-item">Tratamientos</div>
               </a>

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
                     <a href="<?php echo base_url() ?>administrativo/citas/ver" class="nested">
                        <div class="list-group-item opcion">Ver citas</div>
                     </a>
                  </div>
               </div>
         <?php
               break;
         }
         ?>
      </div>
   </section>

   <!--seccion del contenido-->
   <div id="pagina">
      <nav id="header">
         <div class="col perfil">
            <div>Mi perfil <i class="fas fa-cog"></i></div>
         </div>

         <div class="separador-v"></div>

         <div class="col reloj">
            <div class="" id="reloj"></div>
         </div>

         <div class="separador-v"></div>

         <div class="col notificaciones">
            <div class="dropdown">
               <div class="dropbtn headerItem hover" id="notificaciones-text">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones</div>
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