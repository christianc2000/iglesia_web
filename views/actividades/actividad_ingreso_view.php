<!-- css -->

<!-- contenido -->

<div class="d-flex align-items-center">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividad/<?php echo $actividad->nombre ?>/Ingreso</h4>
</div>

<div class="card p-2">
    <div class="card-body flex-column pb-4">
        <form action="?controller=actividades&action=storeRecaudacion" method="POST">
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
                        <label class="form-label" style="color:white">Total Recaudado </label>
                        <p class="form-control"><?php echo $actividad->montoTotal ?></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="ingreso" class="form-label">Detalle de Ingreso</label>
                    <input type="text" id="ingreso" name="ingreso" class="form-control" placeholder="Detalle del ingreso" required>
                    <!-- <select name="ingreso_id" id="ingreso_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php foreach ($ingresos as $i) { ?>
                            <option value=<?php echo $i->id ?>><?php echo $i->nombre ?></option>
                        <?php } ?>
                    </select> -->
                </div>
                <div class="col-md-4">
                    <label for="monto" class="form-label">Monto</label>
                    <input type="number" class="form-control" id="monto" name="monto" placeholder="0.00" required>
                </div>
                <div class="col-md-4 pt-4">
                    <button class="button-principal w-100" type="submit">Añadir Ingreso</button>
                </div>
            </div>
        </form>
        <?php
        $total = 0;
        ?>
        <div class="pt-4">
            <table class="table table-striped col-md-12" id="table" style="width:100%">
                <thead>
                    <th></th>
                    <th>FECHA</th>
                    <th>INGRESO</th>
                    <th>MONTO</th>
                </thead>
                <tbody>
                    <?php

                    foreach ($ingresos as $ingreso) {
                        $total += $ingreso->monto; // Agrega el monto al total
                    ?>
                        <tr>
                            <td>
                                        <form action="?controller=actividades&action=deleteRecaudacion" method="POST">
                                            <input type="hidden" name="ingreso_id" value="<?php echo $ingreso->id; ?>">
                                            <input type="hidden" name="actividad_id" value="<?php echo $ingreso->actividad_id; ?>">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                                        </form>
                            </td>
                            <td><?php echo (DateTime::createFromFormat('Y-m-d H:i:s.u', $ingreso->fecha_registro))->format('Y-m-d H:i:s');?></td>
                            <td><?php echo $ingreso->nombre ?></td>
                            <td><?php echo $ingreso->monto ?></td>
                        </tr>
                    <?php } ?>
                    <!-- Agrega una fila con el total al final de la tabla -->
                    <tr class="total-row">
                        <td colspan="2"></td>
                        <td><strong style="color:black">Total</strong></td>
                        <td><strong style="color:black"><?php echo $total; ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- js -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>