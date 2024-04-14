<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=ministerios&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2"><?php echo $ministerio->nombre."/Cargos"; ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=cargos&action=storeEncargado" method="POST">
            <input type="hidden" name="id" id="id" value="<?php echo $ministerio->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="miembro" class="form-label">Personas</label>
                    <select name="miembro_id" id="miembro_id" class="form-control" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($miembros as $miembro) { ?>
                            <option value=<?php echo $miembro->id ?>><?php echo $miembro->ci . " - " . $miembro->nombre . " " . $miembro->apellido ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="cargo" class="form-label">Tipo de cargos</label>
                    <select name="tipo_cargo_id" id="tipo_cargo_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($tipo_cargos as $tipo_cargo) { ?>
                                <option value=<?php echo $tipo_cargo->id ?>><?php echo $tipo_cargo->nombre ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="fecha_registro" class="form-label">Fecha de inicio</label>
                    <input class="form-control" type="date" name="fecha_registro" id="fecha_registro" required>
                </div>
                <div class="col-md-3 pt-4">
                    <button class="button-principal w-100" type="submit">Agregar</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <h4>ENCARGADOS VIGENTES</h4>
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th>ID</th> <!-- ID DEL HISTORIAL_CARGO -->
                    <th>CARGO</th> <!-- CARGO DEL HISTORIAL_CARGO -->
                    <th>CI</th>
                    <th>MIEMBRO</th> <!-- NOMBRE Y APELLIDO DEL MIEMBRO QUE ESTÁ A CARGO DE ESE MINISTERIO -->
                    <th>REGISTRO</th>
                    <th>OPCIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($miembros_con_cargos as $mc) { ?>
                        <tr>
                            <td><?php echo $mc ['id'] ?></td>
                            <td><?php echo $mc['tipo_cargo_nombre'] ?></td>
                            <td><?php echo $mc['persona_ci'] ?></td>
                            <td><?php echo $mc['persona_nombrecompleto']?></td>
                            <td><?php echo $mc['fecha_registro'];?></td>
                            <td>
                                <form action="?controller=cargos&action=finalizarCargoMinisterio" method="POST">
                                    <input type="hidden" name="ministerio_id" id="ministerio_id" value="<?php echo $ministerio->id; ?>" style="display:block">
                                    <input type="hidden" name="cargo_id" id="cargo_id" value="<?php echo $mc['id']; ?>" style="display:block">
                                    <button type="submit" class="btn btn-dark">Finalizar Cargo</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            <h4>ENCARGADOS NO VIGENTES</h4>
            <table class="table table-striped col-md-12" id="table2" style="width:100%">
                <thead>
                    <th>ID</th> <!-- ID DEL HISTORIAL_CARGO -->
                    <th>CARGO</th> <!-- CARGO DEL HISTORIAL_CARGO -->
                    <th>CI</th>
                    <th>MIEMBRO</th> <!-- NOMBRE Y APELLIDO DEL MIEMBRO QUE ESTÁ A CARGO DE ESE MINISTERIO -->
                    <th>REGISTRO</th>
                    <th>FINALIZACIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($miembros_sin_cargos as $msc) { ?>
                        <tr>
                        <td><?php echo $msc ['id'] ?></td>
                            <td><?php echo $msc['tipo_cargo_nombre'] ?></td>
                            <td><?php echo $msc['persona_ci'] ?></td>
                            <td><?php echo $msc['persona_nombrecompleto']?></td>
                            <td><?php echo $msc['fecha_registro']?></td>
                            <td><?php echo $msc['fecha_finalizacion']?></td>
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
        $('#table2').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Carga el archivo de traducción en español
            },
            order: []
        });
    });
</script>