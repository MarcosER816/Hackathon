<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_hackmorelos = "localhost";
$database_hackmorelos = "hackmorelos";
$username_hackmorelos = "root";
$password_hackmorelos = "";
$hackmorelos = mysql_pconnect($hostname_hackmorelos, $username_hackmorelos, $password_hackmorelos) or trigger_error(mysql_error(),E_USER_ERROR); 
?>