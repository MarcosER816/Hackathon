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

mysql_select_db($database_hackmorelos, $hackmorelos);
$query_Recordset1 = "SELECT usuarios.nombre, usuarios.numero_tel, usuarios.tarjeta_n FROM usuarios";
$Recordset1 = mysql_query($query_Recordset1, $hackmorelos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['tarjeta_n'])) {
  $loginUsername=$_POST['nombre'];
  $password=$_POST['tarjeta_n'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "CONECTION.html";
  $MM_redirectLoginFailed = "conexion_fallida.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_hackmorelos, $hackmorelos);
  
  $LoginRS__query=sprintf("SELECT nombre, tarjeta_n FROM usuarios WHERE nombre=%s AND tarjeta_n=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $hackmorelos) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" href="css/style3.css">
<body>
	<div id="form_holder">
    <div class="login-box">
    <a href="index.html">
        <img src="img/volver.png" alt="" class="img_boton">
      </a>

<h2>ENTRAR</h2>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">
      <div class="user-box">
      <label>Nombre:</label>
      <input type="text" name="nombre" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Numero_tel:</label>
      <input type="text" name="numero_tel" value="" size="32" />
    
    </div>
      <div class="user-box">
      <label>Tarjeta_n:</label>
      <input type="text" name="tarjeta_n" value="" size="32" />
    
    </div>

      <label>&nbsp;
        <a>
      <input type="submit" value="Entrar" />
    </a>
    
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
