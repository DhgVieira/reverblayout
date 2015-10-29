<?php
include 'lib.php';
include 'auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 12px;
    }
</style>
</head>
<body>
<?php
$str = "select
        NR_SEQ_PRODUTO_PRRC, 
        DS_CATEGORIA_PTRC, 
        DS_CATEGORIA_PCRC,
        DS_PRODUTO2_PRRC, 
        VL_PRODUTO_PRRC, 
        NR_PESOGRAMAS_PRRC, 
        VL_PRODUTO2_PRRC,
        if (DS_NCM_PCRC,DS_NCM_PCRC, if (DS_NCM_PCRC, DS_NCM_PCRC, DS_NCM_PTRC))
         from produtos, produtos_categoria, produtos_tipo where NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND
            NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC order by NR_SEQ_PRODUTO_PRRC";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $dado1  = $row[0];
		$dado2	= $row[1];
		$dado3	= $row[2];
        $dado4	= $row[3];
        $dado5	= $row[4];
        $dado6  = $row[5];
        $dado7  = $row[6];
        $dado8  = $row[7];
        
        echo $dado1."|";
        echo $dado2."|";
        echo $dado3."|";
        echo $dado4."|";
        echo $dado5."|";
        echo $dado6."|";
        echo $dado7."|";
        echo $dado8."<br />";
    }
}
?>
</body>
</html>