<?php 

include("con_db.php");
include ("func.php");
if (isset($_POST['register'])) {
     
	    $app = strtoupper($_POST['n1']);
	    $apm = strtoupper($_POST['n2']);
        $nombre = strtoupper($_POST['n3']);
        $tel = strtoupper($_POST['n4']);
        $direccion = strtoupper($_POST['n5']);
        $numcasa = strtoupper($_POST['n6']);
        $barrio = strtoupper($_POST['n7']);
	    $correo = strtoupper($_POST['n8']);
        $f_nac = strtoupper($_POST['n9']);
        $l_nac = strtoupper($_POST['n10']);
	    $estado = strtoupper($_POST['n11']);
        $rfc = strtoupper($_POST['n12']);
        $curp = strtoupper($_POST['n13']);
        $sueldo = strtoupper($_POST['n14']);
        $historial = strtoupper($_POST['n15']);
	    $consulta = "INSERT INTO `clientes`(app, apm, nombre, tel, direccion, numcasa, barrio, correo, f_nac, l_nac, estado, rfc, curp, sueldo, historial) VALUES ('$app', '$apm', '$nombre', '$tel', '$direccion', '$numcasa', '$barrio', '$correo', '$f_nac', '$l_nac', '$estado', '$rfc', '$curp', '$sueldo', '$historial')";
	    $res = mysqli_query($conexion,$consulta);
   

    $sql = "select * FROM clientes";
	if ($res=send_sql($conexion,$sql))
{
  echo "<font color=\"red\">Consulta: <br> $sql </font>";
}
	tab_out($res);
		 
}

?>

<a class="btn" href="clientes.php">Ir a inicio </a>
