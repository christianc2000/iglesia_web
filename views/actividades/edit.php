<div class="d-flex align-items-center">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividades/Editar/<?php echo $actividad->nombre ?></h4>
    </h4>
</div>

<div class="card p-2">
    <form action="?controller=actividades&action=update" method="POST">
        <div class="card-body flex-column pb-4">

            <input type="hidden" name="id" value="<?php echo $actividad->id; ?>" style="display:block">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $actividad->nombre; ?>" id="nombre" name="nombre" placeholder="nombre">
                        <label for="nombreInput">Nombre</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="date" class="form-control" value="<?php echo $actividad->fecha; ?>" name="fecha">
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