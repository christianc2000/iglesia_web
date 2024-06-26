<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        .contenedor {
            max-width: 100%;
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
</head>

<body>
    <?php
    // Recupera el valor del parámetro "nombre"
    $sacramento = $_GET['sacramento'];
    $protagonistas = $_GET['protagonistas'];
    $fecha_hora_actual = $_GET['fecha_hora'];
    $fecha_actividad = $_GET['fecha_actividad'];
    ?>


    <div class="contenedor">
        <div style="text-align: right; font-size:12px; color:darkslategrey">
            <?php echo $fecha_hora_actual; ?>
        </div>
        <h1>Certificado de <?php echo $sacramento ?></h1>
        <h2>Iglesia Parroquial Plan 3000</h2>
        <br>
        <p style="margin-bottom: 1.5em; line-height: 1.8; color: #333;">
            La Parroquia Plan 3000 certifica que
            <strong><?php echo $protagonistas ?></strong>
            recibió el sacramento de
            <strong><?php echo $sacramento ?></strong>.
            Este certificado se otorga en testimonio de su compromiso con la fe y su participación activa en nuestra comunidad parroquial. Que Dios lo bendiga en su camino espiritual y lo guíe siempre hacia la luz de la verdad.
        </p>
        <p>Detalles del Sacramento: </p>
        <?php if ($sacramento == "Matrimonio") {
            echo "<p><strong>Nombre de los Esposos:</strong>";
        } else if ($sacramento == "Bautizo") {
            echo "<p><strong>Nombre del Bautizado:</strong>";
        } else if ($sacramento == "Confirmación") {
            echo "<p><strong>Nombre del Confirmado:</strong>";
        } else {
            echo "<p><strong>Nombre del Comulgante:</strong> ";
        }
        echo " " . $protagonistas . "</p>" ?>

        <p><strong>Fecha del Sacramento:</strong> <?php echo $fecha_actividad ?></p>
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
</body>

</html>

<?php
$html = ob_get_clean();
//  echo $html;
require_once '../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
// $dompdf->setPaper('letter');
$dompdf->setPaper('A4', 'landscape'); //formato para certificados
$dompdf->render();
$dompdf->stream("certificado.pdf", array("Attachment" => false)); //Para que el pdf se muestre, y false para que no se descargue directamente
?>