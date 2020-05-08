<section class="contenido" style="display: none">

   <div class="box">
      <div class="input-group mb-2 mr-sm-2">
         <label for="usuario">Usuario</label>
         <input list="usuarios" class="form-control" id="usuario" placeholder="Nombre" autocomplete="off" required autofocus>
         <datalist id="usuarios"></datalist>
         <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-search"></i></div>
         </div>
      </div>
   </div>
   <div class="box">
      <div class="input-group mb-2 mr-sm-2">
         <label for="centro">Centro</label>
         <input list="centros" class="form-control" id="centro" placeholder="Centro" autocomplete="off" required>
         <datalist id="centros"></datalist>
         <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-search"></i></div>
         </div>
      </div>
   </div>

   <button class="btn btn-primary w-75" id="registrar">Registrar</button>

</section>
</div>
</body>