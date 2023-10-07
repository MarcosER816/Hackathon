<?php require_once('Connections/hackmorelos.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios (nombre, apellido_p, apellido_m, numero_tel, tarjeta_n, NIP) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido_p'], "text"),
                       GetSQLValueString($_POST['apellido_m'], "text"),
                       GetSQLValueString($_POST['numero_tel'], "text"),
                       GetSQLValueString($_POST['tarjeta_n'], "text"),
                       GetSQLValueString($_POST['NIP'], "text"));

  mysql_select_db($database_hackmorelos, $hackmorelos);
  $Result1 = mysql_query($insertSQL, $hackmorelos) or die(mysql_error());

  $insertGoTo = "signin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_hackmorelos, $hackmorelos);
$query_Recordset1 = "SELECT * FROM usuarios";
$Recordset1 = mysql_query($query_Recordset1, $hackmorelos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" href="css/style3.css">
</head>

<body>
<div id="form_holder">
    <div class="login-box">
    <a href="index.html">
        <img src="img/volver.png" alt="" class="img_boton">
      </a>

<h2>Registrarse</h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
      <div class="user-box">
      <label>Nombre:</label>
      <input type="text" name="nombre" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Apellido_p:</label>
      <input type="text" name="apellido_p" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Apellido_m:</label>
      <input type="text" name="apellido_m" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Numero_tel:</label>
      <input type="text" name="numero_tel" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Tarjeta_n:</label>
      <input type="text" name="tarjeta_n" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>NIP:</label>
      <input type="text" name="NIP" value="" size="32" />
    
    </div>

      <label>&nbsp;
        <a>
      <input type="submit" value="Cargar" />
    </a>
    
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
