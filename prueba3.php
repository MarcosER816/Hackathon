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
$query_Recordset1 = "SELECT * FROM usuarios";
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

if (isset($_POST['Tarjeta'])) {
  $loginUsername=$_POST['Tarjeta'];
  $password=$_POST['NIP'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "inicio.html";
  $MM_redirectLoginFailed = "conexion_fallida.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_hackmorelos, $hackmorelos);
  
  $LoginRS__query=sprintf("SELECT tarjeta_n, NIP FROM usuarios WHERE tarjeta_n=%s AND NIP=%s",
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
</head>

<body>
<div id="form_holder">
    <div class="login-box">
      <a href="index.html">
        <img src="img/volver.png" alt="" class="img_boton">
      </a>

<h2>Login</h2>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
      <div class="user-box">
        <label for="Tarjeta">No. Tarjeta</label>
        <input type="text" name="Tarjeta" id="Tarjeta" />
      </div>
      <div class="user-box">
        <label for="NIP">NIP</label>
        <input type="text" name="NIP" id="NIP" />
      </div>
  <CENTER>
    <a href="">
  	  <input type="submit" name="button" id="button" value="Enviar" />
    </a>
  </CENTER>
</form>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
