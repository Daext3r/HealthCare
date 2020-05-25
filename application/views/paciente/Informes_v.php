        <section class="contenido" style="display: none">
           <div class="filtro">
              <div class="col">
                 <label for="especialidad">Especialidad</label>
                 <select id="especialidad" class="form-control">
                    <option value="todas" selected>Todas</option>
                 </select>
              </div>
              <div class="col">
                 <label for="facultativo">Facultativo</label>
                 <select id="facultativo" class="form-control">
                    <option value="cualquiera" selected>Cualquiera</option>
                 </select>
              </div>
              <div class="col">
                 <label for="privados">Informes privados</label>
                 <select id="privados" class="form-control">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                 </select>
              </div>
              <div class="col">
                 <label for="reset">Borar filtros</label><br>
                 <button id="reset" class="btn btn-primary w-100">Borrar</button>
              </div>
           </div>
           <hr>
           <div class="lista" id="lista"></div>
        </section>
        </div>
        </body>