<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de <?php echo $sacramento->nombre?></title>
    <style>
        /* Estilos CSS para el certificado */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Certificado de <?php echo $sacramento->nombre?></h1>
    <p>Por la presente se certifica que:</p>
    <p><strong>
        <?php echo $protagonistas?>
    </strong></p>
    <p>ha completado con éxito el curso de <strong>Dompdf</strong>.</p>
    <p>Firma del Instructor</p>
</body>
</html>