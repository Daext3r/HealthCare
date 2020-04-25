<section class="contenido">
   <div class="my-row row" id="buscador">
      <div class="my-col col">
         <label for="usuario">Usuario</label>
         <div class="input-group mb-2 mr-sm-2">
            <input list="usuarios" class="form-control" id="usuario" placeholder="Nombre" autocomplete="off" required autofocus>
            <datalist id="usuarios"></datalist>
            <div class="input-group-prepend">
               <div class="input-group-text"><i class="fas fa-search"></i></div>
            </div>
         </div>
      </div>
      <h4>Busca un usuario y selecciónalo</h4>
   </div>

   <div class="datos" style="display: none;">
      <div class="my-row row">
         <div class="col my-col">
            <label for="colegiado">Nº de Colegiado</label>
            <input type="text" id="colegiado" placeholder="Nº de colegiado" class="form-control">
         </div>
         <div class="col my-col">
            <label for="sala">Sala en la que trabajará</label>
            <input type="text" id="sala" placeholder="Identificador" class="form-control">
         </div>
      </div>

      <div class="my-row row">
         <div class="col my-col">
            <label for="especialidad">Especialidad</label>
            <input list="especialidades" class="form-control" id="especialidad" placeholder="Especialidad" autocomplete="off" required autofocus>
            <datalist id="especialidades"></datalist>
         </div>

         <div class="col my-col">
            <label for="especialidad">Centro</label>
            <input list="centros" class="form-control" id="centro" placeholder="Centro" autocomplete="off" required autofocus>
            <datalist id="centros"></datalist>
         </div>
      </div>

      <div class="my-row row">
         <button class="btn btn-primary" id="registrar">Dar de alta como facultativo</button>
      </div>
   </div>
</section>
</div>
</body>