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
         <ul class="list-group">
            <?php
            //miramos el tipo del usuario
            switch ($this->session->userdata('tipo')) {
                  //si es paciente...
               case 'paciente':
            ?>
                  <a href="<?php echo base_url() ?>paciente/inicio">
                     <li class="list-group-item">Inicio</li>
                  </a>
                  <a href="<?php echo base_url() ?>paciente/citas">
                     <li class="list-group-item">Citas</li>
                  </a>
                  <a href="<?php echo base_url() ?>paciente/tratamientos">
                     <li class="list-group-item">Tratamientos</li>
                  </a>
                  <a href="<?php echo base_url() ?>paciente/informes">
                     <li class="list-group-item">Informes</li>
                  </a>
                  <!--<a href="<?php //echo base_url() 
                                 ?>paciente/misdatos">
                     <li class="list-group-item last">Mis Datos</li>
                  </a>-->
               <?php
                  break;
                  //si es admin...
               case 'admin':
               ?>
                  <a href="<?php echo base_url() ?>admin/inicio">
                     <li class="list-group-item">Inicio</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/crear/usuario">
                     <li class="list-group-item">Crear usuario</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/crear/centro">
                     <li class="list-group-item">Crear centro</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/nuevo/paciente">
                     <li class="list-group-item">Nuevo paciente</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/nuevo/facultativo">
                     <li class="list-group-item">Nuevo facultativo</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/administrar/usuario">
                     <li class="list-group-item">Datos de usuario</li>
                  </a>
                  <a href="<?php echo base_url() ?>admin/administrar/centro">
                     <li class="list-group-item">Administrar centro</li>
                  </a>
               <?php
                  break;
                  //si es gerente...
               case 'gerente':
               ?>
                  <a href="<?php echo base_url() ?>gerente/inicio">
                     <li class="list-group-item">Inicio</li>
                  </a>
                  <a href="<?php echo base_url() ?>gerente/crearUsuario">
                     <li class="list-group-item">Crear usuario</li>
                  </a>
                  <a href="<?php echo base_url() ?>gerente/nuevo/paciente">
                     <li class="list-group-item">Nuevo paciente</li>
                  </a>
                  <a href="<?php echo base_url() ?>gerente/nuevo/facultativo">
                     <li class="list-group-item">Nuevo facultativo</li>
                  </a>
                  <a href="<?php echo base_url() ?>gerente/gestionarAdministrativos">
                     <li class="list-group-item">Gestionar administrativos</li>
                  </a>
                  <a href="<?php echo base_url() ?>gerente/traslados">
                     <li class="list-group-item">Traslados</li>
                  </a>
               <?php
                  break;
                  //si es facultativo...
               case 'facultativo':
               ?>
                  <a href="<?php echo base_url() ?>facultativo/inicio">
                     <li class="list-group-item">Inicio</li>
                  </a>
                  <a href="<?php echo base_url() ?>facultativo/citas">
                     <li class="list-group-item">Citas</li>
                  </a>
               <?php
                  break;
               case 'administrativo':
               ?>
                  <a href="<?php echo base_url() ?>administrativo/inicio">
                     <li class="list-group-item">Inicio</li>
                  </a>
                  <a href="<?php echo base_url() ?>administrativo/crearUsuario">
                     <li class="list-group-item">Crear usuario</li>
                  </a>
                  <a href="<?php echo base_url() ?>administrativo/nuevo/facultativo">
                     <li class="list-group-item">Nuevo facultativo</li>
                  </a>
                  <a href="<?php echo base_url() ?>administrativo/nuevo/personal_lab">
                     <li class="list-group-item">Nuevo Técnico Lab.</li>
                  </a>
                  <a href="<?php echo base_url() ?>administrativo/nuevo/paciente">
                     <li class="list-group-item">Nuevo paciente</li>
                  </a>
            <?php
                  break;
            }
            ?>
         </ul>
      </div>
   </section>

   <!--seccion del contenido-->
   <div id="pagina">
      <nav id="header">
         <div class="headerItem" id="reloj"></div>

         <div class="separador-v"></div>

         <div class="dropdown">
            <div class="dropbtn headerItem hover" id="notificaciones-text">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones pendientes</div>
            <div class="dropdown-content" id="listaNotificaciones"></div>
         </div>

         <div class="separador-v"></div>

         <div id="logout"><i class="fas fa-sign-out-alt"></i>
            <p>Salir</p>
         </div>
      </nav>