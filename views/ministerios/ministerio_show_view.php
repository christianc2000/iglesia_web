<div class="d-flex align-items-center">
    <a href="?controller=ministerios&action=index" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Ministerio | ver | <?php echo $ministerio->nombre ?></h4>
</div>

<div class="card vh-100 p-2">
    <div class="card-body flex-column h-100">
        <div class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-md-12">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?php echo $ministerio->nombre; ?>" disabled>
                    <label for="nombreInput">Nombre</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Describe el ministerio" id="descripcion" name="descripcion" style="height: 100px" disabled><?php echo $ministerio->descripcion; ?></textarea>
                    <label for="descripcion">Descripción</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="estado" name="estado" value="<?php echo ($ministerio->estado) ? 'HABILITADO' : 'DESHABILITADO'; ?>" disabled>
                    <label for="estadoInput">Estado</label>
                </div>
            </div>
        </div>
    </div>
</div>