<style>
    .contenedor {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: Arial, Helvetica, sans-serif;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 10px;
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
<div class="contenedor">
<div style="text-align: right; font-size:12px; color:darkslategrey">
        <?php echo $fecha_hora_actual; ?>
    </div>
    <h1>Certificado de <?php echo $sacramento->nombre ?></h1>
    <h2>Iglesia Parroquial Plan 3000</h2>
    <br>
    <p>La Parroquia Plan 3000 certifica que <strong><?php echo $protagonistas ?></strong> recibió el sacramento de <strong><?php echo $sacramento->nombre ?></strong>.</p>
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
    
</div>