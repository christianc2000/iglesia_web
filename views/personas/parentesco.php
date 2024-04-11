<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=personas&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Persona/Parentezco/<?php echo $persona->nombre . " " . $persona->apellido; ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <form action="?controller=personas&action=storeParentesco" method="POST">
            <input type="hidden" name="personaA_id" id="personaA_id" value="<?php echo $persona->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="miembro" class="form-label">Persona</label>
                    <select name="personaB_id" id="personaB_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($personas as $p) { ?>
                                <option value=<?php echo $p['persona_id'] ?>><?php echo $p['persona_ci'] . " - " . $p['persona_nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="parentezco" class="form-label">Parentesco</label>
                    <select name="tipo_parentesco_id" id="tipo_parentesco_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($tipo_parentescos as $tipo_parentesco) { ?>
                                <option value=<?php echo $tipo_parentesco->id ?>><?php echo $tipo_parentesco->nombre?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit">Agregar</button>
                </div>
            </div>
        </form>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th>CI</th>
                    <th>PARIENTE</th>
                    <th>PARENTESCO</th>
                    <th>OPCIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($parientes as $pariente) { ?>
                        <tr>
                            <td><?php echo $pariente['pariente_ci'] ?></td>
                            <td><?php echo $pariente['pariente_nombre'] ?></td>
                            <td><?php echo $pariente['parentesco'] ?></td>
                            <td>
                                <form action="?controller=personas&action=deleteParentesco" method="POST">
                                    <input type="hidden" name="personaA_id" id="personaA_id" value="<?php echo $persona->id; ?>" style="display:block">
                                    <input type="hidden" name="personaB_id" id="personaB_id" value="<?php echo $pariente['pariente_id']; ?>" style="display:block">
                                    <button type="submit" class="btn btn-dark">Eliminar</button>
                                </form>
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