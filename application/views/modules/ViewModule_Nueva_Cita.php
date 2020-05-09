<section class="contenido" style="display: none;">
   <div class="buscador">
      <div class="row">
         <div class="col">
            <label for="paciente">Paciente:</label>
            <input list="pacientes" id="paciente" placeholder="Paciente" class="form-control">
            <datalist id="pacientes"></datalist>
         </div>

         <div class="col">
            <label for="facultativo">Facultativo:</label>
            <input list="facultativos" id="facultativo" placeholder="Facultativo" class="form-control">
            <datalist id="facultativos"></datalist>
         </div>
      </div>

      <div class="row">
         <div class="col">
            <label for="hora">Hora aproximada</label>
            <select name="hora" id="hora" class="form-control citas-select" disabled>
            </select>
         </div>
         <div class="col">
            <label for="minuto">Minuto aproximado</label>
            <select name="minuto" id="minuto" class="form-control citas-select" disabled>
            </select>
         </div>
      </div>

      <div class="row">
         <div class="col">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" required disabled>
         </div>
         <div class="col">
            <label>Nota:</label>
            <h5>La fecha y hora que usted solicite son orientativas.</h5>
         </div>
      </div>

      <div class="row">
         <div class="col d-flex justify-content-center">
            <button class="w-75 btn btn-primary" id="buscar" disabled>Buscar citas</button>
         </div>
      </div>
   </div>


   <div class="horas" style="display: none;">
      <table id="horas" class="table mt-3">
         <thead>
            <tr class="table-primary">
               <td>Fecha</td>
               <td>Hora</td>
               <td>Acciones</td>
            </tr>
         </thead>
      </table>
   </div>
</section>
</div>
</body>