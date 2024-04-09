<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividad/<?php echo $actividad->nombre ?>/Asistencia</h4>
</div>

<div class="card p-2">
    <div class="card-body flex-column pb-4">
        <form action="?controller=actividades&action=storeAsistencia" method="POST">
            <input type="hidden" name="actividad_id" id="actividad_id" value="<?php echo $actividad->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-12 row" style="background-color: #241910;">
                    <div class="col-md-3">
                        <label class="form-label" style="color:white">Fecha </label>
                        <p class="form-control"><?php echo $actividad->fecha ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color:white">Hora Inicio </label>
                        <p class="form-control"><?php echo $actividad->horaInicio ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color:white">Hora Fin </label>
                        <p class="form-control"><?php echo $actividad->horaFin ?></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color:white">Monto Total </label>
                        <p class="form-control"><?php echo $actividad->montoTotal ?></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="miembro" class="form-label">Miembro</label>
                    <select name="persona_id" id="persona_id" class="form-select" required>
                        <?php if (count($personas) > 0) { ?>
                            <option value="" selected disabled>Seleccione un miembro</option>
                            <?php foreach ($personas as $persona) { ?>
                                <option value=<?php echo $persona->id ?>><?php echo $persona->ci . " - " . $persona->nombre . " " . $persona->apellido ?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <option value="" selected disabled> Sin miembros para marcar asistencia</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 pt-4">
                <button class="button-principal w-100" type="submit" <?php echo (count($personas) == 0 ? 'disabled' : ''); ?>>Marcar asistencia</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th></th>
                    <th>FECHA ASISTENCIA</th>
                    <th>MIEMBRO</th>
                    <th>HORA LLEGADA</th>
                    <th>ESTADO</th>
                </thead>
                <tbody>
                    <?php foreach ($asistencias as $asistencia) { ?>

                        <tr>
                            <td>
                                <form action="?controller=actividades&action=deleteAsistencia" method="POST">
                                    <input type="hidden" name="persona_id" value="<?php echo $asistencia['persona_id']; ?>">
                                    <input type="hidden" name="actividad_id" value="<?php echo $asistencia['actividad_id']; ?>">
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                            <?php
                            // echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $asistencia[0]->created_at))->format('Y-m-d H:i:s');
                            // $fechaHoraAsistencia = (DateTime::createFromFormat('Y-m-d H:i:s.u', $asistencia['fecha_registro']))->format('Y-m-d H:i:s');
                            $fechaHoraAsistencia = DateTime::createFromFormat('Y-m-d H:i:s.u', $asistencia['fecha_registro']);
                            $fechaHoraActividad = new DateTime($actividad->fecha . ' ' . $actividad->horaInicio);
                            ?>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.u', $asistencia['fecha_registro']))->format('Y-m-d H:i:s'); ?></td>
                            <td><?php echo $asistencia['persona_nombrecompleto'] ?></td>
                            <td><?php echo $asistencia['horallegada'] ?></td>
                            <td>

                                <?php if ($fechaHoraAsistencia < $fechaHoraActividad) { ?>
                                    <div style="background-color: #0FFFC8;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                        Asistió a tiempo
                                    <div>
                                <?php } else { ?>
                                    <div style="background-color: #241910; color:white;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                                Llegó tarde
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- js -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"></script> <!-- Agrega el archivo de traducción en español -->

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Carga el archivo de traducción en español
            },
            order: []
        });
    });
</script>