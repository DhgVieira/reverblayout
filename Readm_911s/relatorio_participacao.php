<?php
include 'auth.php';
include 'lib.php';

$aba = request("aba");
$mes = request("mes");
$ano = request("ano");
    
$corpo="";
$largura = 1020;
$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatorio</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 14px;
    }
    	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:20px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:14px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
</head>
<body>
<table width="<?php echo $largura; ?>" >
	<tr><td>&nbsp;</td>
    	<td align="right">&nbsp;</td>
    	<td align="right">&nbsp;</td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Atividade no Site</strong><br /><font size="-1">Referente: <?php echo date('d/m/Y')?></font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
<?php
$moderador[0] = 6605; //gabi
$moderador[1] = 3388; // caio
$moderador[2] = 4162; // marcio
$moderador[3] = 10470; // Jana
$moderador[4] = 32609; // Gustavo
$moderador[5] = 26087; // ROse
$moderador[6] = 8185; // Chloe
$moderador[7] = 2; // tony
$moderador[8] = 29424; // Diego
$moderador[9] = 22652; // Miria
$moderador[10] = 5189; // Ronchi
$moderador[11] = 356432; // Jonatas

// $dtaini = date('Y-m-d', mktime(0, 0, 0, $mes, 1 , $ano));
// $dtafim = date('Y-m-d', mktime(0, 0, 0, $mes, date('t') , $ano));


echo "<tr bgcolor=\"#DFDFDF\"><td align=center><strong>Topicos</strong></td><td align=center><strong>Msgs</strong></td><td align=center><strong>Enquetes</strong></td><td align=center><strong>Enq.Coment</strong></td><td align=center><strong>Blog Com.</strong></td><td align=center><strong>Prod.Com.</strong></td><td align=center><strong>Fotos Com.</strong></td><td align=center><strong>Compras</strong></td><td align=center><strong>TOTAL</strong></td></tr>\n";

$strmiolo = "";

//select 'votos', count(*) from enquetes_votos where NR_SEQ_CADASTRO_EVRC = ".$moderador[$f]." and DT_VOTO_EVRC BETWEEN '$dtaini' and '$dtafim' GROUP BY NR_SEQ_ENQUETE_EVRC union

for ($f=0;$f<=11;$f++){
    $total = 0;
    $sql2 = "select DS_NOME_CASO FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = ".$moderador[$f];
    $st2 = mysql_query($sql2);
    if (mysql_num_rows($st2) > 0) {
        $row2 = mysql_fetch_row($st2);
        $strmiolo .= "<tr bgcolor=\"#DFDFDF\"><td colspan=9><strong>".$row2[0]."</strong></td></tr>\n";
        $strmiolo .= "<tr>\n";
    }
    $sql = "SELECT count(*) from topicos where NR_SEQ_CADASTRO_TOSO = ".$moderador[$f]." and DT_CADASTRO_TOSO < DATE_SUB(NOW(), INTERVAL 30 DAY)";
   
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "select count(*) from msgs where NR_SEQ_CADASTRO_MESO = ".$moderador[$f]." and DT_CADASTRO_MESO < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "select count(*) from enquetes where NR_SEQ_CADASTRO_EQRC = ".$moderador[$f]." and DT_CRIACAO_EQRC < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "SELECT count(*) from enquetes_coments where NR_SEQ_CADASTRO_CERC = ".$moderador[$f]." and DT_COMENT_CERC < DATE_SUB(NOW(), INTERVAL 30 DAY)";
 
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "select count(*) from blog_coments where NR_SEQ_CADASTRO_CBRC = ".$moderador[$f]." and DT_CADASTRO_CBRC < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "select count(*) from produtos_coments where NR_SEQ_CADASTRO_PCRC = ".$moderador[$f]." and DT_COMENT_PCRC < DATE_SUB(NOW(), INTERVAL 30 DAY)";

    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "select count(*) from me_fotos_coments where NR_SEQ_CADASTRO_MCRC = ".$moderador[$f]." and DT_CADASTRO_MCRC < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }
    $sql = "SELECT count(*) from compras where NR_SEQ_CADASTRO_COSO = ".$moderador[$f]." and ST_COMPRA_COSO <> 'C' and DT_COMPRA_COSO < DATE_SUB(NOW(), INTERVAL 30 DAY);";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
         $row = mysql_fetch_row($st);
         $total += $row[0];
         $strmiolo .= "<td align=center>".$row[0]."</td>\n";
    }else{
         $strmiolo .= "<td align=center>0</td>\n";
    }

    $strmiolo .= "<td align=center><strong>$total</strong></td>\n";
    $strmiolo .= "</tr>\n";
}

echo $strmiolo;
?>
    <tr><td colspan="8">&nbsp;</td></tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
</body>
</html>