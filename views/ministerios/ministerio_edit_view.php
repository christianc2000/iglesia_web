<div class="d-flex align-items-center">
    <a href="?controller=ministerios&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Ministerio | Editar | <?php echo $ministerio->nombre ?></h4>
</div>

<div class="card p-2">
    <form action="?controller=ministerios&action=update" method="POST">
        <div class="card-body flex-column pb-4">
            <input type="hidden" name="id" value="<?php echo $ministerio->id; ?>" style="display:block">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?php echo $ministerio->nombre; ?>" required>
                        <label for="nombreInput">Nombre</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Describe el ministerio" id="descripcion" name="descripcion" style="height: 100px" required><?php echo $ministerio->descripcion; ?></textarea>
                        <label for="descripcionInput">Descripción</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <select class="form-select" aria-label="Default select status" id="estado" name="estado">
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="1" <?php echo ($ministerio->estado == 1) ? 'selected' : ''; ?>>HABILITAR</option>
                        <option value="0" <?php echo ($ministerio->estado == 0) ? 'selected' : ''; ?>>DESHABILITAR</option>
                    </select>
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