<div class="d-flex align-items-center">
    <a href="?controller=personas&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Persona/Editar/<?php echo $persona->nombre . " " . $persona->apellido ?></h4>
</div>

<div class="card p-2">
    <form action="?controller=personas&action=update" method="POST">
        <div class="card-body flex-column pb-4">
            <input type="hidden" name="id" value="<?php echo $persona->id; ?>" style="display:block">
            <div class="row g-3 px-2">
                <div class="col-md-6">
                    <label for="ci" class="form-label">CI</label>
                    <input class="form-control" type="text" name="ci" id="ci" value=<?php echo $persona->ci ?> required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">CORREO</label>
                    <input class="form-control" type="email" name="correo" id="correo" value=<?php echo $persona->correo ?> required>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">NOMBRE</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $persona->nombre ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">APELLIDO</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $persona->apellido ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="celular" class="form-label">CELULAR</label>
                    <input class="form-control" type="number" name="celular" id="celular" value=<?php echo $persona->celular ?> required>
                </div>
                <div class="col-md-6">
                    <label for="direccion" class="form-label">DIRECCION</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $persona->direccion ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="tipo" class="form-label">TIPO</label>
                    <select class="form-select" name="tipo" id="tipo" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="M" <?php if ($persona->tipo === "M") {
                                                echo "selected";
                                            } ?>>Miembro</option>
                        <option value="F" <?php if ($persona->tipo === "V") {
                                                echo "selected";
                                            } ?>>Visitante</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sexo" class="form-label">SEXO</label>
                    <select class="form-select" name="sexo" id="sexo" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="M" <?php if ($persona->sexo === "M") {
                                                echo "selected";
                                            } ?>>Masculino</option>
                        <option value="F" <?php if ($persona->sexo === "F") {
                                                echo "selected";
                                            } ?>>Femenino</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="fecha_nacimiento" class="form-label">FECHA DE NACIMIENTO</label>
                    <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value=<?php echo $persona->fecha_nacimiento ?> required>
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