<?php
// Datos de la base de datos
	$usuario = "root";
	$password = "";
	$servidor = "localhost";
	$basededatos = "techzone";
	
	// creaci�n de la conexi�n a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
	
	// Selecci�n del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
?>


