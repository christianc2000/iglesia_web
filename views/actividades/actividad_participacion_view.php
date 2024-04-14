<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center" style="margin-bottom: 5px;">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividad/<?php echo $sacramento->nombre ?></h4> <a class="btn btn-primary" href="?controller=certificados&&action=generarPDF&&id=<?php echo $actividad->id?>"><i class="fas fa-certificate"></i> Certificado</a>
</div>

<div class="card p-2">
    <div class="card-body flex-column pb-4">
        <form action="?controller=participacions&action=storeParticipacion" method="POST">
            <input type="hidden" name="actividad_id" id="actividad_id" value="<?php echo $actividad->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-12 row" style="background-color: #241910;">
                    <div class="col-md-4">
                        <label class="form-label" style="color:white">Fecha </label>
                        <p class="form-control"><?php echo $actividad->fecha ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="color:white">Hora Inicio </label>
                        <p class="form-control"><?php echo $actividad->horaInicio ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="color:white">Hora Fin </label>
                        <p class="form-control"><?php echo $actividad->horaFin ?></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="miembro" class="form-label">Persona</label>
                    <select name="persona_id" id="persona_id" class="form-select" required>
                        <?php if (count($personas) > 0) { ?>
                            <option value="" selected disabled>Seleccione una persona</option>
                            <?php foreach ($personas as $persona) { ?>
                                <option value=<?php echo $persona->id ?>><?php echo $persona->ci . " - " . $persona->nombre . " " . $persona->apellido ?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <option value="" selected disabled> Sin personas para agregar al sacramento</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tipo_participacion_id" class="form-label">Tipo de Participación</label>
                    <select name="tipo_participacion_id" id="tipo_participacion_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($tipo_participacions as $tipo_participacion) { ?>
                            <option value=<?php echo $tipo_participacion->id ?>><?php echo $tipo_participacion->nombre ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit" <?php echo (count($personas) == 0 ? 'disabled' : ''); ?>>Agregar Participante</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th></th>
                    <th>FECHA</th>
                    <th>PARTICIPANTE</th>
                    <th>TIPO DE PARTICIPACIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($participacions as $participacion) { ?>

                        <tr>
                            <td>
                                <form action="?controller=participacions&action=deleteParticipacion" method="POST">
                                    <input type="hidden" name="persona_id" value="<?php echo $participacion['persona_id']; ?>">
                                    <input type="hidden" name="actividad_id" value="<?php echo $participacion['actividad_id']; ?>">
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.u', $participacion['fecha_registro']))->format('Y-m-d H:i:s'); ?></td>
                            <td><?php echo $participacion['persona_nombrecompleto'] ?></td>
                            <?php if ($participacion['tipo_participacion_id'] == "1") { ?>
                                <td style="color: #4CCD99;font-weight: 700; text-align: center;border-radius: 10px;"><?php echo $participacion['tipo_participacion_nombre'] ?></td>
                            <?php } else { ?>
                                <td style="text-align:center;font-weight: 700"><?php echo $participacion['tipo_participacion_nombre'] ?></td>
                            <?php } ?>
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