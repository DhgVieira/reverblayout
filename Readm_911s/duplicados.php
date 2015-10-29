<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
include 'lib.php';
include 'auth.php';

$str = "select DS_CPFCNPJ_CASO, count(*) as total from cadastros where NR_SEQ_CADASTRO_CASO not in (2,4160,2130,6605) group by DS_CPFCNPJ_CASO order by total desc, DS_CPFCNPJ_CASO";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
	while($row = mysql_fetch_row($st)) {
		$cnpj	   	= $row[0];
		$qtde		= $row[1];
		
		if ($qtde > 1) {
			$sql2 = "SELECT * FROM cadastros WHERE DS_CPFCNPJ_CASO = '$cnpj' and NR_SEQ_CADASTRO_CASO not in (2,4160,2130,6605)";
			$st2 = mysql_query($sql2);
			if (mysql_num_rows($st2) > 0) {
				while($row2 = mysql_fetch_array($st2)) {
					$nomecad = $row2["DS_NOME_CASO"];
					//echo "<a href=\"duplicados_del.php?idc=".$row2["NR_SEQ_CADASTRO_CASO"]."\" target=\"_blank\">xxx</a> ->";
                    echo $row2["NR_SEQ_CADASTRO_CASO"]." - ";
					if (!$row2["DS_CPFCNPJ_CASO"] || $row2["DS_CPFCNPJ_CASO"] == " " || trim($row2["DS_CPFCNPJ_CASO"]) == "" || $row2["DS_CPFCNPJ_CASO"] == "-") {
						echo "Sem CPF----\t";
					}else{
						echo $row2["DS_CPFCNPJ_CASO"]."\t";
					}
					echo $nomecad." - ".$row2["DS_EMAIL_CASO"];
					$sql3 = "SELECT NR_SEQ_CADASTRO_COSO, NR_SEQ_COMPRA_COSO FROM compras WHERE NR_SEQ_CADASTRO_COSO = ".$row2["NR_SEQ_CADASTRO_CASO"];
					$st3 = mysql_query($sql3);
					if (mysql_num_rows($st3) <= 0) {
						echo " - <font color=\"#FF0000\">SEM COMPRAS</font>";
					}else{
					   echo " - Compras:";
                       while($row3 = mysql_fetch_array($st3)) {
                         echo " (".$row3[1].") ";
                       }
					}
					//$sql4 = "SELECT NR_SEQ_CADASTRO_CASO FROM cadastros WHERE DS_NOME_CASO = '".$nomecad."' and NR_SEQ_CADASTRO_CASO <> ".$row2["NR_SEQ_CADASTRO_CASO"];
					//$st4 = mysql_query($sql4);
					//if (mysql_num_rows($st4) > 0) {
					//	echo " - <font color=\"#0000FF\">POSSUI OUTRO CADASTRO</font>";
					//}
					$sql4 = "SELECT NR_SEQ_CADASTRO_MESO FROM msgs WHERE NR_SEQ_CADASTRO_MESO = ".$row2["NR_SEQ_CADASTRO_CASO"];
					$st4 = mysql_query($sql4);
					if (mysql_num_rows($st4) > 0) {
						echo " - <font color=\"#00FF00\">MENSAGEM FÓRUM</font>";
					}
                    $ddd = $row2["DS_DDDFONE_CASO"];
                    $fone = $row2["DS_FONE_CASO"];
                    if (($ddd || $fone) && ($ddd != "-" || $fone != "-")) echo " - Fone: ($ddd) $fone";
                    
                    echo " - ".$row2["DS_CIDADE_CASO"] . "/" . $row2["DS_UF_CASO"];
                    
					echo "<br />";
				}
			}
		}
	}
}

mysql_close($con);
?>
</body>
</html>