<div class="d-flex align-items-center">
    <a href="?controller=personas&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Miembro | crear</h4>
</div>

<div class="card p-2">
    <form action="?controller=personas&action=store" method="POST">
        <div class="card-body flex-column pb-4">

            <div class="row g-3 px-5">
                <div class="col-md-6">
                    <label for="ci" class="form-label">CI</label>
                    <input class="form-control" type="text" name="ci" id="ci" required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">CORREO</label>
                    <input class="form-control" type="email" name="correo" id="correo" required>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">NOMBRE</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">APELLIDO</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" required>
                </div>
                <div class="col-md-6">
                    <label for="celular" class="form-label">CELULAR</label>
                    <input class="form-control" type="number" name="celular" id="celular" required>
                </div>
                <div class="col-md-6">
                    <label for="direccion" class="form-label">DIRECCION</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" required>
                </div>
                <div class="col-md-6">
                    <label for="sexo" class="form-label">SEXO</label>
                    <select class="form-select" name="sexo" id="sexo" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="fecha_nacimiento" class="form-label">FECHA DE NACIMIENTO</label>
                    <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>
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