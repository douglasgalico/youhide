<?php require_once('../Connections/teste.php'); ?>
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

$insertSQL = sprintf("INSERT INTO random_link (ip) VALUES (%s)",
				   GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"));

mysql_select_db($database_teste, $teste);
$Result1 = mysql_query($insertSQL, $teste) or die(mysql_error());


mysql_select_db($database_teste, $teste);
$query_entradas = "SELECT * FROM random_link";
$entradas = mysql_query($query_entradas, $teste) or die(mysql_error());
$row_entradas = mysql_fetch_assoc($entradas);
$totalRows_entradas = mysql_num_rows($entradas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

if($totalRows_entradas % 2 == 0){
	echo "<a href='#' target='_self'>1</a>";
} else {
	echo "<a href='#' target='_self'>0</a>";
}

?>
</body>
</html>
<?php
mysql_free_result($entradas);
?>
