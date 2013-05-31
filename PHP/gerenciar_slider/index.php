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

mysql_select_db($database_teste, $teste);
$query_slider = "SELECT * FROM slider WHERE ativo LIKE '%sim%' ORDER BY idslider ASC";
$slider = mysql_query($query_slider, $teste) or die(mysql_error());
$row_slider = mysql_fetch_assoc($slider);
$totalRows_slider = mysql_num_rows($slider);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
if(!$row_slider == 0){
do { ?>
<img src="upload/slider/<?php echo $row_slider['imgnome']; ?>" title="<?php echo $row_slider['descricao']; ?>" width="640" height="325" />
<?php }
while ($row_slider = mysql_fetch_assoc($slider)); 
} ?>
</body>	
</html>
<?php
mysql_free_result($slider);
?>
