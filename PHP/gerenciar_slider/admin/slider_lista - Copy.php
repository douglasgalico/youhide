<?php require_once('../../Connections/teste.php'); ?>
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
$query_sliderLista = "SELECT * FROM slider ORDER BY ativo DESC";
$sliderLista = mysql_query($query_sliderLista, $teste) or die(mysql_error());
$row_sliderLista = mysql_fetch_assoc($sliderLista);
$totalRows_sliderLista = mysql_num_rows($sliderLista);

if ((isset($_GET['idslider'])) && ($_GET['idslider'] != "")) {
  $deleteSQL = sprintf("DELETE FROM slider WHERE idslider=%s",
                       GetSQLValueString($_GET['idslider'], "int"));
  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($deleteSQL, $teste) or die(mysql_error());
  unlink("../upload/slider/".$_GET['imgname']);
  header("location: slider_lista.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>idslider</td>
    <td>descricao</td>
    <td>imgnome</td>
    <td>ativo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_sliderLista['idslider']; ?></td>
      <td><?php echo $row_sliderLista['descricao']; ?></td>
      <td><?php echo $row_sliderLista['imgnome']; ?></td>
      <td><?php echo $row_sliderLista['ativo']; ?></td>
      <td><a href="?idslider=<?php echo $row_sliderLista['idslider']; ?>&imgname=<?php echo $row_sliderLista['imgnome']; ?>">Apagar</a></td>
    </tr>
    <?php } while ($row_sliderLista = mysql_fetch_assoc($sliderLista)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($sliderLista);
?>
