<?php

	require('conexion.php');

	$idProvincia=$_POST['idProvincia'];
	print_r($idProvincia);

	$queryC = "SELECT idCanton,nombreCanton FROM `codificacion_mh` WHERE idProvincia = '$idProvincia' GROUP by nombreCanton";

	$resultadoC= $mysqli->query($queryC);

	
	$html= "<option value='0'>Seleccionar Canton </option>";

	while($rowC=$resultadoC->fetch_assoc())
	{
		$html= "<option value='".$rowC['idCanton']."'>".$rowC['nombreCanton']." </option>";
	}
	echo $html;




?>