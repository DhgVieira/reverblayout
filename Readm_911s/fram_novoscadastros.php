<?php 
include 'lib.php';
$aba = request("aba");
$mes = request("mes");
$ano = request("ano");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - ADM</title>
</head>
<frameset rows="160,*" frameborder="no" border="0" framespacing="0">
  <frame src="topo_frame.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frame src="rel_novoscadastros.php?aba=<?php echo $aba; ?>&mes=<?php echo $mes; ?>&ano=<?php echo $ano; ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>