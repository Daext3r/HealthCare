<body>
   <div class="row shadow-lg p-3 mb-5 bg-white rounded">
      <?php

      //si tiene acceso al perfil de paciente
      if ($perfiles['paciente'] == true) {
      ?>
         <div class="card" style="width: 18em;">
            <div class="card-logo">
               <i class="fas fa-briefcase-medical"></i>
            </div>

            <div class="card-body">
               <h5 class="card-title">Paciente</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como paciente</h6>
               <p class="card-text">Accede a la plataforma como paciente de tu centro de salud</p>
               <a href="<?php echo base_url() ?>Permisos/index/paciente" class="btn btn-primary">Entrar</a>

            </div>
         </div>
      <?php
      }

      //si tiene acceso al perfil de medico
      if ($perfiles['facultativo'] == true) {
      ?>
         <div class="card" style="width: 18em;">
            <div class="card-logo">
               <i class="fas fa-user-md"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Facultativo</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como facultativo</h6>
               <p class="card-text">Accede a la plataforma como profesional médico en tu centro de salud</p>
               <a href="<?php echo base_url() ?>Permisos/index/facultativo" class="btn btn-primary">Entrar</a>

            </div>
         </div>
      <?php
      }

      //si tiene acceso al perfil de laboratorio
      if ($perfiles['personal_lab'] == true) {
      ?>
         <div class="card" style="width: 18rem;">
            <div class="card-logo">
               <i class="fas fa-syringe"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Personal de laboratorio</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como Personal de laboratorio</h6>
               <p class="card-text">Accede a la plataforma como personal de laboratorio para analizar muestras</p>
               <a href="<?php echo base_url() ?>Permisos/index/laboratorio" class="btn btn-primary">Entrar</a>
            </div>
         </div>
      <?php
      }

      //si tiene acceso al perfil de gerente de un centro
      if ($perfiles['gerente'] == true) {
      ?>
         <div class="card" style="width: 18rem;">
            <div class="card-logo">
               <i class="fas fa-users"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Gerente</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como gerente</h6>
               <p class="card-text">Accede a la plataforma como gerente para administrar los trabajadores de tu centro</p>
               <a href="<?php echo base_url() ?>Permisos/index/gerente" class="btn btn-primary">Entrar</a>
            </div>
         </div>
      <?php
      }

      //si tiene acceso al perfil de administrativo de un centro
      if ($perfiles['administrativo'] == true) {
      ?>
         <div class="card" style="width: 18rem;">
            <div class="card-logo">
               <i class="fas fa-paste"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Administrativo</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como administrativo</h6>
               <p class="card-text">Accede a la plataforma como adminsitrativo de tu centro de salud</p>
               <a href="<?php echo base_url() ?>Permisos/index/administrativo" class="btn btn-primary">Entrar</a>
            </div>
         </div>
      <?php
      }

      //si tiene acceso al perfil de administrador del sistema
      if ($perfiles['admin'] == true) {
      ?>
         <div class="card" style="width: 18rem;">
            <div class="card-logo">
               <i class="fas fa-cogs"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Administrador del sistema</h5>
               <h6 class="card-subtitle mb-2 text-muted">Entrar como administrador del sistema</h6>
               <p class="card-text">Accede a la plataforma como administrador de la misma</p>
               <a href="<?php echo base_url() ?>Permisos/index/admin" class="btn btn-primary">Entrar</a>
            </div>
         </div>
      <?php
      }
      ?>
   </div>
</body>