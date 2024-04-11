<div class="d-flex align-items-center">
    <a href="?controller=actividads&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividades/crear</h4>
</div>

<div class="card p-2">
    <form action="?controller=actividades&action=store" method="POST">
        <div class="card-body flex-column pb-4">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="sacramento_id" id="sacramento_id" class="form-select" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php foreach ($sacramentos as $sacramento) { ?>
                                <option value=<?php echo $sacramento->id ?>><?php echo $sacramento->nombre ?></option>
                            <?php } ?>
                        </select>
                        <label for="sacramentoInput">Sacramento</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" name="fecha">
                        <label for="fechaInput">Fecha</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="time" class="form-control" name="hora_inicio">
                        <label for="hora_inicioInput">Hora Inicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="time" class="form-control" name="hora_fin">
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