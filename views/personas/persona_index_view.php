<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<h4>Miembros</h4>
<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="pb-4">
            <a class="button-principal" href="?controller=personas&action=create">Registrar Miembro</a>
            <!-- <a class="button-cancelar" href="?controller=personas&action=index_suspended">personas suspendidos</a> -->
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>CI</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>CELULAR</th>
                <th>CORREO</th>
                <th>REGISTRO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>
                <?php foreach ($personas as $persona) { ?>
                    <tr>
                        <td><?php echo $persona->ci ?></td>
                        <td><?php echo $persona->nombre ?></td>
                        <td><?php echo $persona->apellido ?></td>
                        <td><?php echo $persona->celular ?></td>
                        <td><?php echo $persona->correo ?></td>
                        <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.u', $persona->fecha_registro))->format('Y-m-d H:i:s'); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=personas&action=edit&id=<?php echo $persona->id; ?>'><i class="fa fa-edit"></i> Editar</a></li>
                                    <li><a class="dropdown-item" href="?controller=parentescos&action=parentesco&id=<?php echo $persona->id; ?>"><i class="fa fa-layer-group"></i> Parentesco</a></li>
                                    <li><a class="dropdown-item" href='?controller=personas&action=delete&id=<?php echo $persona->id; ?>'><i class="fa fa-trash"></i> Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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