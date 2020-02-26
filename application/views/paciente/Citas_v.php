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
                        $html .= "<td class='citas-anular'><button class='btn btn-danger w-75 anular'>&times;</button></td>";
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
                            ...
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