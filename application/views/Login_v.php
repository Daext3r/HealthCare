<body>
   <div class="row shadow-lg p-3 mb-5 bg-white rounded">

      <img src="<?php echo base_url() ?>assets/img/logo.png" alt="" srcset="" class="col-12 col-md-8 col-l-7 col-xl-5">

      <form method="POST" action="<?php echo base_url() ?>Login_controller/login" class="col-md-12 col-xl-5" id="form" style="display: none;">
         <?php if ($this->session->flashdata('error') == 'no_user') { ?>
            <div class="alert alert-danger" role="alert">
               Datos de acceso incorrectos. Prueba de nuevo.
            </div>
         <?php } ?>
         <div class="form-group">
            <label for="correo">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico">
         </div>
         <div class="form-group">
            <label for="clave">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" placeholder="Clave">

         </div>
         <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="recuerdame" name="recuerdame" checked="checked">
            <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
         </div>
         <button id="qr" class="btn btn-outline-primary" type="button">Escanear QR</button>
         <input type="submit" class="btn btn-success" value="Iniciar sesión" id="iniciar-sesion">

         <input type="hidden" name="jwt" id="jwt">
      </form>

      <div class="col-md-12 col-xl-5" id="load">
         <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
         </div>
      </div>

      <div class="col-md-12 col-xl-5" id="seleccion" style="display: none">
            <div class="w-100 correo">¿Tu correo es <span id="seleccion-correo"></span>?</div>
            <button class="btn btn-outline-success seleccion" data-seleccion="si">Sí, es mi correo</button>
            <button class="btn btn-outline-danger seleccion" data-seleccion="no">No, no es mi correo</button>
      </div>
   </div>
</body>