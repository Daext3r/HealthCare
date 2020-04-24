<section class="contenido">
   <div class="my-row row" id="buscador" style="display: none;">
      <div class="my-col col">
         <label for="usuario">Usuario</label>
         <div class="input-group mb-2 mr-sm-2">
            <input list="usuarios" class="form-control" id="usuario" placeholder="CIU" autocomplete="off" required autofocus>
            <datalist id="usuarios"></datalist>
            <div class="input-group-prepend">
               <div class="input-group-text"><i class="fas fa-search"></i></div>
            </div>
         </div>
      </div>
      <h4>Busca un usuario y selecciónalo</h4>
   </div>

   <div class="datos">
      <div class="my-row row">
         <div class="col my-col">
            <label for="grupo_sanguineo">Grupo sanguíneo</label>
            <input type="text" id="grupo_sanguineo" placeholder="Grupo sanguineo" class="form-control" maxlength="4">
         </div>
      </div>

      <div class="my-row row">
         <div class="col my-col">
            <label for="fac1">Médico/a</label>
            <input list="fac1list" class="form-control" id="fac1" placeholder="Médico/a" autocomplete="off" required autofocus>
            <datalist id="fac1list"></datalist>
         </div>

         <div class="col my-col">
            <label for="fac2">Enfermero/a</label>
            <input list="fac2list" class="form-control" id="fac2" placeholder="Enfermero/a" autocomplete="off" required autofocus>
            <datalist id="fac2list"></datalist>
         </div>
      </div>

      <div class="my-row row">
         <button class="btn btn-primary" id="registrar">Dar de alta como paciente</button>
      </div>
   </div>
</section>