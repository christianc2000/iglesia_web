<!-- css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- contenido -->

<h4>Ministerios</h4>
<div class="card p-2">
    <div class="card-body flex-column pb-4">
        <div class="pb-4">
            <a class="button-principal" href="?controller=ministerios&action=create">Crear Ministerio</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ESTADO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>

                <?php foreach ($ministerios as $ministerio) { ?>
                    <tr>
                        <td><?php echo $ministerio->id ?></td>
                        <td><?php echo $ministerio->nombre ?></td>
                        <td class="p-2" style="align-items: center;">
                            <?php if ($ministerio->estado) { ?>
                                <div style="background-color: #0FFFC8;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                    HABILITADO
                                </div>
                            <?php } else { ?>
                                <div style="background-color: #241910; color:white;font-weight: 700; text-align: center; margin: 5px; border-radius: 10px;">
                                    DESHABILITADO
                                </div>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=show&id=<?php echo $ministerio->id;?>'><i class="fas fa-eye"></i> Ver</a></li>
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=edit&id=<?php echo $ministerio->id;?>'><i class="fa fa-edit"></i> Editar</a></li>
                                    <li><a class="dropdown-item" href='?controller=ministerios&action=cargos&id=<?php echo $ministerio->id;?>'><i class="fas fa-user-tie"></i> Encargados</a></li>
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