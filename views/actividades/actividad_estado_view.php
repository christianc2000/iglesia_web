<div class="d-flex align-items-center">
    <a href="?controller=actividades&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Actividades/estado</h4>
</div>

<div class="card p-2">

    <form action="?controller=actividades&action=storeEstado" method="POST">
        <div class="card-body flex-column pb-4">
            <?php
            // Verifica si hay un mensaje de error en la variable de sesión
            if (isset($_GET['error'])) {
                // Muestra el mensaje de error
                echo "<p style='color:red'>{$_GET['error']}</p>";
               
            }
            ?>
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <h4>Estado actual: <?php echo "" . $estado->nombre ?></h4>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="estado_id" id="estado_id" class="form-select" required>
                            <option value="" disabled>Seleccione una opción</option>
                            <?php foreach ($estados as $e) { ?>
                                <option value=<?php echo $e->id ?> <?php echo (($e->id == $estado->id) ? 'selected' : '') ?>><?php echo $e->nombre ?></option>
                            <?php } ?>
                        </select>
                        <label for="sacramentoInput">Estados</label>
                    </div>
                </div>
                <input type="hidden" name="actividad_id" value=<?php echo "" . $actividad->id ?>>

            </div>
            <div class="card-footer py-4" style="display: flex; justify-content: flex-end;">
                <div class="row px-2">
                    <div class="col-12">
                        <button type="submit" class="button-principal btn-sm">Guardar</button>
                    </div>
                </div>
            </div>
    </form>
</div>