<style>
    .contenedor {
        max-width: 1050px;
        margin: 0 auto;
        padding: 30px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 28px;
        margin-bottom: 10px;
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 20px;
        margin-bottom: 10px;
    }
</style>
<div class="d-flex align-items-center">
    <a href="?controller=participacions&action=participacion&id=<?php echo $actividad->id ?>" style="color: black"><i class="fa fa-lg fa-arrow-left"></i></a>
    <h4 class="px-2">Certificado</h4>
    <a href="views/certificados/certificado.php?<?php echo "sacramento=" . $sacramento->nombre . "&fecha_hora=" . $fecha_hora_actual . "&protagonistas=" . $protagonistas . "&fecha_actividad=" . $actividad->fecha ?>" class="btn btn-danger" style="margin-bottom:10px"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
</div>
<div class="contenedor">
    <div style="text-align: right; font-size:12px; color:darkslategrey">
        <?php echo $fecha_hora_actual; ?>
    </div>
    <h1>Certificado de <?php echo $sacramento->nombre ?></h1>
    <h2>Iglesia Parroquial Plan 3000</h2>
    <br>
    <p style="margin-bottom: 1.5em; line-height: 1.8; color: #333;">
        La Parroquia Plan 3000 certifica que
        <strong><?php echo $protagonistas ?></strong>
        recibió el sacramento de
        <strong><?php echo $sacramento->nombre ?></strong>.
        Este certificado se otorga en testimonio de su compromiso con la fe y su participación activa en nuestra comunidad parroquial. Que Dios lo bendiga en su camino espiritual y lo guíe siempre hacia la luz de la verdad.
    </p>
    <p>Detalles del Sacramento: </p>
    <?php if ($sacramento->nombre == "Matrimonio") {
        echo "<p><strong>Nombre de los Esposos:</strong>";
    } else if ($sacramento->nombre == "Bautizo") {
        echo "<p><strong>Nombre del Bautizado:</strong>";
    } else if ($sacramento->nombre == "Confirmación") {
        echo "<p><strong>Nombre del Confirmado:</strong>";
    } else {
        echo "<p><strong>Nombre del Comulgante:</strong> ";
    }
    echo " " . $protagonistas . "</p>" ?>

    <p><strong>Fecha del Sacramento:</strong> <?php echo $actividad->fecha ?></p>
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <p style="margin-bottom:0px;margin-top: 80px;">_________________________</p>
            <p>Firma del Párroco</p>
        </div>
    </div>
    <br>
    <div style="text-align: right; color: #888; font-style: italic; margin-top: 10px;">
        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: lighter; margin-bottom: 0;">Nota: Este certificado es válido para uso religioso y no tiene valor legal.</p>
    </div>
</div>