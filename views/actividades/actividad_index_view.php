<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Contenido -->
<h4>Actividad</h4>
<div class="card p-2">
    <div class="card-body flex-column pb-4">
        <div class="pb-4">
            <a class="button-principal" href="?controller=actividades&action=create">Crear Actividad</a>
        </div>
        <table class="table table-striped" id="table" style="width:100%">
            <thead>
                <th>ID</th>
                <th>FECHA</th>
                <th>HORA INICIO</th>
                <th>HORA FIN</th>
                <th>ESTADO</th>
                <th>SACRAMENTO</th>
                <th>OPCIÓN</th>
            </thead>
            <tbody>
                <?php foreach ($actividades as $actividad) { ?>
                    <tr>
                        <td><?php echo $actividad['id'] ?></td>
                        <td><?php echo $actividad['fecha'] ?></td>
                        <td><?php echo $actividad['horaInicio'] ?></td>
                        <td><?php echo $actividad['horaFin'] ?></td>
                        <td><div style="text-align:center;width:auto;padding:8px; border-radius: 10px;background:<?php echo ($actividad['estado']=='Pendiente'?'#448EF6':($actividad['estado']=="En progreso"?'#04CC00':($actividad['estado']=="Completado"?'#000000':($actividad['estado']=="Suspendido"?'#FFCD29':'#FF0303'))))?>; color:white"><?php echo $actividad['estado'] ?></div></td>
                        <td><?php echo $actividad['sacramento_nombre'] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href='?controller=actividades&action=edit&id=<?php echo $actividad['id']; ?>'><i class="fa fa-edit"></i> Editar</a></li>
                                    <!-- <li><a class="dropdown-item" href='?controller=actividades&action=recaudacion&id=<?php echo $actividad['id']; ?>'><i class="fa fa-money-bill-wave"></i> Ingreso </a></li> -->
                                    <li><a class="dropdown-item" href='?controller=participacions&action=participacion&id=<?php echo $actividad['id']; ?>'><i class="fa fa-calendar"></i> Participación</a></li>
                                    <li><a class="dropdown-item" href='?controller=actividades&action=estado&id=<?php echo $actividad['id']; ?>'><i class="fa fa-exchange-alt"></i> Estado</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recaudación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?controller=actividads&action=storeRecaudacion" method="POST">
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <input type="hidden"  id="actividad_id" name="actividad_id"  value="">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="monto_total" name="monto_total" placeholder="monto total">
                                <label for="montoTotalInput">Monto Total</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="button-principal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JS -->
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
<script>
    function setRecaudacionValues(id, montoTotal) {
        document.getElementById('actividad_id').value = id;
        document.getElementById('monto_total').value = montoTotal;
    }
</script>