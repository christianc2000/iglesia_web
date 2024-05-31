<?php
$sacramento = $datos['sacramento'];
$protagonistas = $datos['protagonista'];
$fecha_hora_actual = $datos['fecha_hora'];
$fecha_actividad = $datos['fecha_actividad'];
?>
<p style="text-align: right; font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: lighter; margin-bottom: 0;"><?php echo "Bolivia, Santa Cruz ".$fecha_hora_actual; ?></p>
<p style="margin-top: 30pt;text-align: center;font-size: 18px;font-weight: bold">Certificado de <?php echo $sacramento ?></p>
<p style="text-align: center;font-size: 16px;font-weight: 300">Iglesia Parroquial Plan 3000</p>
<p style="margin-top: 30pt; line-height: 1.8; color: #333;">
La Parroquia Plan 3000 certifica que
<strong> <?php echo $protagonistas." " ?></strong>
recibió el sacramento de 
<strong><?php echo $sacramento.". " ?></strong>Este certificado se otorga en testimonio de su compromiso con la fe y su participación activa en nuestra comunidad parroquial. Que Dios lo bendiga en su camino espiritual y lo guíe siempre hacia la luz de la verdad.
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
<p style="text-align: center;margin-top: 40pt">_________________________</p>
<p style="text-align: center;">Firma del Párroco</p>
<p style="text-align: right; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: lighter; margin-top: 20pt">Nota: Este certificado es válido para uso religioso y no tiene valor legal.</p>