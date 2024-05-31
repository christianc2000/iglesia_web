<div class="d-flex align-items-center">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividad | <?php echo $sacramento->nombre ?> | Editar</h4>
    </h4>
</div>

<div class="card p-2">
    <form action="?controller=actividades&action=update" method="POST">
        <div class="card-body flex-column pb-4">
            <input type="hidden" name="id" value="<?php echo $actividad->id; ?>" style="display:block">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-floating">
                        <p class="form-control"><?php echo $actividad->id?></p>
                        <label for="Código">Código</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="sacramento_id" id="sacramento_id" class="form-select" required>
                            <?php foreach ($sacramentos as $s) { ?>
                                <option value="<?php echo $s->id ?>" <?php echo ($s->id == $actividad->sacramento_id ? 'selected' : '') ?>><?php echo $s->nombre ?></option>
                            <?php } ?>
                        </select>
                        <label for="sacramentoInput">Sacramento</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="date" class="form-control" value="<?php echo $actividad->fecha; ?>" name="fecha" min="<?php echo date('Y-m-d'); ?>">
                        <label for="fechaInput">Fecha</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="time" class="form-control" value="<?php echo $actividad->horaInicio; ?>" name="hora_inicio">
                        <label for="hora_inicioInput">Hora Inicio</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="time" class="form-control" value="<?php echo $actividad->horaFin; ?>" name="hora_fin">
                        <label for="hora_finInput">Hora Fin</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer" style="display: flex; justify-content: flex-end;">
            <div class="row px-2">
                <div class="col-12">
                    <button type="submit" class="button-principal btn-sm">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>