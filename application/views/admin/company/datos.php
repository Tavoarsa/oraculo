<?php
mysql_connect('localhost','root','Gas/1234');
mysql_select_db('restaurante');

$Accion=$_REQUEST['Accion'];

if(is_callable($Accion))
{
	$Accion();
}

funtion GetProvincias(){

	header('Content-Type:application/json');
	$Provincias=array();
	$Consulta=mysql_query("SELECT idProvincia,nombreProvincia FROM `codificacion_mh` WHERE idProvincia <=7 GROUP by nombreProvincia");

	while($Fila= mysql_fetch_assoc($Consulta)){

		$Provincias[]= $Fila;
	}
	echo json_encode($Provincias);
}


?>