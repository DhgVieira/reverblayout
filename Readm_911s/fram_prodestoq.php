<?php 
include 'lib.php';
$aba = request("aba");
$loja = request("loja");
$tipo = request("tipo");
$ordem = request("ordem");
$status = request("status");
$tamanho = request("tamtam");
$categoria = request("catcat");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - ADM</title>
</head>
<frameset rows="160,*" frameborder="no" border="0" framespacing="0">
  <frame src="topo_frame.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frame src="rel_prodestoque.php?aba=<?php echo $aba; ?>&loja=<?php echo $loja; ?>&tipo=<?php echo $tipo; ?>&ordem=<?php echo $ordem; ?>&status=<?php echo $status; ?>&categoria=<?php echo $categoria; ?>&tamanho=<?php echo $tamanho; ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>