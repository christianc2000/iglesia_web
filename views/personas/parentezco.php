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
        <form action="?controller=personas&action=storeParentezco" method="POST">
            <input type="hidden" name="personaA_id" id="personaA_id" value="<?php echo $persona->id; ?>" style="display:block">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="miembro" class="form-label">Persona</label>
                    <select name="personaB_id" id="personaB_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($personas as $p) { ?>
                            <?php if ($p->id != $persona->id) { ?>
                                <option value=<?php echo $p->id ?>><?php echo $p->ci . " - " . $p->nombre . " " . $p->apellido ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="parentezco" class="form-label">Parentezco</label>
                    <input class="form-control" type="text" name="parentezco" id="parentezco" required>
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
                    <th>PARENTEZO</th>
                    <th>OPCIÓN</th>
                </thead>
                <tbody>
                    <?php foreach ($parentezcos as $parentezco) { ?>
                        <tr>
                            <td><?php echo $parentezco['pariente_ci'] ?></td>
                            <td><?php echo $parentezco['pariente_nombre'] ?></td>
                            <td><?php echo $parentezco['parentezco'] ?></td>
                            <td>
                                <form action="?controller=personas&action=deleteParentezco" method="POST">
                                <input type="hidden" name="persona_id" id="persona_id" value="<?php echo $persona->id; ?>" style="display:block">
                                    <input type="hidden" name="personaA_id" id="personaA_id" value="<?php echo $parentezco['personaA_id']; ?>" style="display:block">
                                    <input type="hidden" name="personaB_id" id="personaB_id" value="<?php echo $parentezco['personaB_id']; ?>" style="display:block">
                                    <button type="submit" class="btn btn-dark">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="pt-4">
            <h4>Parentezco Relacionados</h4>
            <table class="table table-striped col-md-12" id="table2" style="width:100%">
                <thead>
                    <th>CI</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>FECHA REGISTRADO</th>
                    <th class="text-uppercase"><?php echo $miembro[1]->nombre . " " . $miembro[1]->apellido . " RELACIONADA COMO " ?></th>
                </thead>
                <tbody>
                    <?php foreach ($parentezcos_relacionados as $parentezco) { ?>
                        <tr>
                            <td><?php echo $parentezco[1]->ci ?></td>
                            <td><?php echo $parentezco[1]->nombre ?></td>
                            <td><?php echo $parentezco[1]->apellido ?></td>
                            <td><?php echo $parentezco[1]->fecha_nacimiento ?></td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.uP', $parentezco[0]->created_at))->format('Y-m-d H:i:s'); ?></td>
                            <td class="m-1" style="background-color: #0FFFC8;font-weight: 700;"><?php echo $parentezco[0]->parentezco ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> -->
    </div>
</div>
<!-- js -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    new DataTable('#table', {
        order: []
    });
</script>