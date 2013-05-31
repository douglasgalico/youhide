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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php
if($_POST){
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 20000000)
	&& in_array($extension, $allowedExts)){
		if ($_FILES["file"]["error"] > 0){
			echo "Codigo de retorno: " . $_FILES["file"]["error"] . "<br>";
		} else {
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Tipo: " . $_FILES["file"]["type"] . "<br>";
			echo "Tamanho: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Arquivo Temp.: " . $_FILES["file"]["tmp_name"] . "<br>";
			if (file_exists("../upload/slider/" . $_FILES["file"]["name"])){
				echo $_FILES["file"]["name"] . " já existe. ";
			} else {
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"../upload/slider/" . $_FILES["file"]["name"]);
				echo "Guardado em: " . "../upload/slider/" . $_FILES["file"]["name"];
				if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO slider (descricao, imgnome, ativo) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_FILES["file"]["name"], "text"),
                       GetSQLValueString($_POST['ativo'], "text"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($insertSQL, $teste) or die(mysql_error());
}
			}
		}
	} else {
		echo "Arquivo Invalido";
	}
}
?>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <p>
    <label for="arquivo">Arquivo</label>
    <input type="file" name="file" id="file" />
  </p>
  <p>
    <label for="descricao">Descrição</label>
    <input type="text" name="descricao" id="descricao" />
  </p>
  <p>Ativo?</p>
  <p>
    <label>
      <input type="radio" name="ativo" value="sim" id="Ativo_0" checked="checked" />
    Sim</label>
    <br />
    <label>
      <input type="radio" name="ativo" value="nao" id="Ativo_1" />
      Não</label>
  </p>
  <p>
    <input type="submit" name="button" id="button" value="Enviar" />
    <br />
  </p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>