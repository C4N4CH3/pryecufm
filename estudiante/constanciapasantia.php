<?php
include ("sesiones.php");
if($_SESSION['nivel']!=$_SESSION['id']){
session_destroy();
echo "FALLA GRAVE AL SISTEMA, PERDISTE LA SESION, PARA REGRESAR AL INICIO REINICIA EL NAVEGADOR";exit();
}

$ci = $_SESSION['cedula'];
include "conexionbd.php";
$consulta = "select * from alumno where cedula_alumno='$ci'";
$resultado = mysql_query($consulta) or die (mysql_error());
if ($fila = mysql_fetch_array($resultado)){
    $mencion = $fila["id_mencion"];
	$nombre = $fila["nombre"];
	$apellido = $fila["apellido"];
	$carnet = $fila["carnet"];
	$carrera = $fila["id_carrera"];
}
$consulta2 = "select * from carreras where id_carrera=$carrera";
$nombre_carrera = mysql_query($consulta2) or die (mysql_error());

if ($fila = mysql_fetch_array($nombre_carrera)){
    $nombre_car = utf8_encode($fila["nombre_carrera"]);
}

$consulta3 = "select * from menciones where id_mencion=$mencion";;
$nombre_mencion = mysql_query($consulta3) or die (mysql_error());
 
if ($fila = mysql_fetch_array($nombre_mencion)){
    $nombre_men = utf8_encode($fila["nombre_mencion"]);
}
$hoy= date("Y-n-j");
mysql_close($link);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Constancia de Pasant&iacute;as</title>
<link href="../css/bootstrap/3.3.0/bootstrap.min.css" rel="stylesheet">
<link href="../css/material/roboto.min.css" rel="stylesheet">
<link href="../css/material/material.min.css" rel="stylesheet">
<link href="../css/material/ripples.min.css" rel="stylesheet">
<link href="../css/material/materialmodif.css" rel="stylesheet">
</head>

<body>
<form action="" method="post">

<?php include_once '../navbar.php';?>
  <div class="sidebar1"> 
 <?php require_once 'menu_al.php';?>
 </div>
  <div class="content">
 <h2 align="center">Constancia de Pasant&iacute;as </h2>
 <h4><p align="center">Antes de continuar por favor verifica que tus datos esten correctos:</p></h4>

 <table width="100%"% border="0" align="center">
   <tr>
     <td width="50%" align="right"><em>Nombres y Apellidos:</em></td>
     <td ><?php echo $nombre." ".$apellido?></td>
   </tr>
   <tr>
     <td align="right"><em>C&eacute;dula:</em></td>
     <td><?php echo $ci?></td>
   </tr>
   <tr>
     <td align="right"><em>Carnet:</em></td>
     <td><?php echo $carnet?></td>
   </tr>
   <tr>
     <td align="right"><em>Carrera:</em></td>
     <td><?php echo $nombre_car?></td>
   </tr>
   <tr>
     <td height="29" align="right"><em>Menci&oacute;n:</em></td>
     <td width="50%"><?php echo $nombre_men?></td>
   </tr>
   <tr>
     <td align="center">&nbsp;</td>
	 <td align="center">&nbsp;</td>
   </tr>
   <tr>
     <td width="50%" align="center" colspan="2"><b> Datos centro de pasant&iacute;a: </b></td>
   </tr>
   <tr>
     <td align="center">&nbsp;</td>
	 <td align="center">&nbsp;</td>
   </tr>
   <tr>
     <td align="right">Fecha de Solicitud de constancia:</td>
     <td width="50%"><input name="fecha_actual" type="text" onkeypress="return validarTextoNumero(event)" value="<?php echo $hoy;?>" size="15">
     </td>
   </tr>
   <tr>
     <td width="50%" align="right">Nombre del Centro de Pasant&iacute;as:</td>
     <td width="50%"><input name="nombre_centro" type="text" onkeypress="return validarTextoNumero(event)" value="<?php if(isset($_POST['nombre_centro'])) echo $_POST['nombre_centro']?>" size="15"></td>
   </tr>
   <tr>
     <td align="right">Dirigido a:</td>
     <td><input name="carta_dirigida" type="text" onkeypress="return validarTexto(event)" value="<?php if(isset($_POST['carta_dirigida'])) echo $_POST['carta_dirigida']?>" size="15"></td>
   </tr>
   <tr>
     <td align="right">Cargo que desempe&ntilde;a:</td>
     <td><input name="cargo_asignado" type="text" onkeypress="return validarTextoNumero(event)" value="<?php if(isset($_POST['cargo_asignado'])) echo $_POST['cargo_asignado']?>" size="15"></td>
   </tr>
   <tr>
     <td height="27" align="right">Lapso pasantias:</td>
     <td><input name="telefono_lapso" type="text" onkeypress="return validarTextoNumero(event)" value="<?php if(isset($_POST['telefono_lapso'])) echo $_POST['telefono_lapso']?>" size="15"></td>
   </tr>
   <p>&nbsp; </p>
   <tr>
     <td align="right"><input type="reset" name="limpiar" value="Limpiar"/></td>
     <td align="left"><input type="submit" name="enviar" value="Aceptar" onClick="validarconstanciapasantia(this.form)"/></td>
   </tr>
 </table>
 <p>&nbsp; </p>
	<p>&nbsp; </p>
  </div>
<div class="sidebar2">
  <h4 align="center">Bienvenido: <?php echo $_SESSION['usuario']?></h4>
  <p align="center"><a href="cerrarsesion.php">Cerrar Sesi&oacute;n</a>    <!-- end .sidebar2 --></p>
  <p>
  
  <?php if (isset($_GET["errorpreinscripcion"]) && $_GET["errorpreinscripcion"]=="si"){
		echo "<font color=red> Ud. no est&aacute; preinscrito!</font>";
		echo "<script language=JavaScript>alert('Ud. no est&aacute; preinscrito!');</script>";
	} 
	?> 
	
	  <?php if (isset($_GET["errorcant_documentos"]) && $_GET["	errorcant_documentos"]=="si"){
		echo "<font color=red> Ud. alcanz&oacute; el l&iacute;mite de solicitud de constancias!</font>";
		echo "<script language=JavaScript>alert('Ud. alcanz&oacute; el l&iacute;mite de solicitud de constancias!');</script>";
	} 
	?>
	  </p>
 </div></form>
  <?php include_once '../footer.php';?>

<script type="text/javascript" src="../js/1.11.1/jquery.min.js"></script>
<script src="../js/bootstrap/3.3.0/bootstrap.min.js"></script>
<script src="../js/material/material.min.js"></script>
<script src="../js/material/ripples.min.js"></script>
<script>
      $.material.init();
</script>


<script language="javascript" src="validardocumento.js"></script>
<script type="text/javascript">
//valida solo texto
function validarTexto(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if ( (tecla==8) || (tecla==9) || (tecla==32))
	{
		return true;
	}
    patron = /(\W?[^\][\\}{\+\*\?\/\_\-\.\¨`´:;,çÇ¿¡'=()&%$·"!ªº|@#~½¬ 0-9])/;
    te = String.fromCharCode(tecla); 
    return patron.test(te);
}
//valida texto y numeros
function validarTextoNumero(e) { 	
	tecla = (document.all)?e.keyCode:e.which;
	if ( (tecla==8) || (tecla==9))
	{
		return true;
	}
	patron = /\d|(\W?[^\][\\}{\+\*\?\¨`´:;,çÇ¿¡'=()&%$·"!ªº|@#~½¬])/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarNumero(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if ( (tecla==8) || (tecla==9))
	{
		return true;
	} 
    patron = /\d|(\W?[^\.\][\\}{\+\*\?\/\_\-\¨`´:;,çÇ¿¡'=()&%$·"!ªº|@#~½¬a-zA-Z Ññ])/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te);
}
function validarEmail(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if ( (tecla==8) || (tecla==9) )
	{
		return true;
	} 
    patron = /\d|(\W?[^\][\\}{\+\*\?\/\¨`´:;,çÇ¿¡'%=()&%$·"!ªº|#~½¬])/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te);
}
</script>
</body>
</html>