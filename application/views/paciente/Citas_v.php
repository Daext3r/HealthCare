        <section id="citas-contenido">
            <table class="table">

                <tr class="table-primary">
                    <th scope="col">Médico</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Acciones</th>
                </tr>

                <?php
                if (count($citas) > 0) {

                    //mostramos una fila por cada cita
                    foreach ($citas as $cita) {
                        $html = "<tr>";
                        $html .= "<td>$cita[nombre_medico]</td>";
                        $html .= "<td>" . date('d-m-Y', strtotime($cita['fecha'])) . "</td>";
                        $html .= "<td>$cita[hora]</td>";
                        $html .= "<td class='citas-anular'><button class='btn btn-danger w-75 anular-cita-btn' data-id-cita='$cita[id]'>&times;</button></td>";
                        $html .= "</tr>";
                        echo $html;
                    }
                } else {
                    echo "<tr><td colspan='4'><h5>No tienes citas programadas</h5></td></tr>";
                }
                ?>
            </table>

            <button type="button" class="btn btn-primary w-75" data-toggle="modal" data-target="#pedirCita">Nueva Cita</button>

            <!-- Modal de nueva cita-->
            <div class="modal fade" id="pedirCita" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pedir nueva cita</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="medico">Médico:</label>
                            <select id="medico" class="form-control">
                                <?php
                                    foreach($facultativos as $facultativo) {
                                        echo "<option value='$facultativo[CIU_medico]'>$facultativo[medico]</option>";
                                    }
                                ?>
                            </select>

                            <label for="fecha">Fecha:</label>
                            <input type="date" min="<?php echo date("Y-m-d") ?>" class="form-control" id="fecha">

                            <label for="hora">Hora aproximada</label>
                            <input type="number" id="hora" min="9" max="15" value="9" class="form-control">
                            <input type="number" id="minuto" min="0" max="55" value="00" step="05" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
        </body>