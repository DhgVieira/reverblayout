<?php
include 'auth.php';
include 'lib.php';
$idcli = request("idcli");
$idc = request("idc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalhamento Pedido</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>

<table width="615" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
  	<td>
        <table width="100%">
        	<tr>
            	<td><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td>
                <td>
                    <table width="100%">
                        <tr>
                        	<td width="25%">&nbsp;</td>
                            <td align="right">
                            <?php if ($idc) { ?>
                            <input type="Button" value="VOLTAR" onClick="document.location.href=('compras_ver.php?idc=<?php echo $idc ?>&nrcli=<?php echo $idcli ?>');" class="form00" style="width:100px;height:23px;" />
                            <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
   	</td>
  </tr>
</table>
<?php 
$sql2 = "select DT_LANCAMENTO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, DS_NOME_CASO, NR_SEQ_CONTA_CRSA, NR_SEQ_COMPRA_CRSA, NR_SEQ_CADASTRO_CRSA from contacorrente, cadastros WHERE
		 NR_SEQ_CADASTRO_CRSA = NR_SEQ_CADASTRO_CASO and NR_SEQ_CADASTRO_CRSA = $idcli order by DT_LANCAMENTO_CRSA";
$st = mysql_query($sql2);
if (mysql_num_rows($st) > 0) {
?>
	<table width="615" class="textosver" align="center">
    	<tr bgcolor="#CACCE8">
        	<td width="150"><strong>Data</strong></td>
            <td><strong>Descrição</strong></td>
            <td width="100" align="center"><strong>Compra</strong></td>
            <td width="70" align="center"><strong>Valor</strong></td>
            <td width="30" align="center"><strong>Tipo</strong></td>
        </tr>
    </table>
<?php
$valorfim = 0;
while($row2 = mysql_fetch_row($st)) {
 $datalct   = $row2[0];
 $vlrlcto   = $row2[1];
 $tiplcto   = $row2[2];
 $dsobs     = $row2[3];
 $nome      = $row2[4];
 $nrseqlc   = $row2[5];
 $nrseqcomp = $row2[6];
 $nrseqcad  = $row2[7];
 
 $valorfim += $vlrlcto;
?>
	<table width="615" class="textosver" align="center">
    	<tr>
        	<td width="150"><?php echo date("d/m/Y G:i", strtotime($datalct));?></td>
            <td><?php echo $dsobs;?></td>
            <td width="100" align="center">
            <?php if ($nrseqcomp){ ?>
            <a href="compras_ver.php?idcli=<?php echo $nrseqcad;?>&idc=<?php echo $nrseqcomp;?>" title="Detalhamento da Compra Nr <?php echo $nrseqcomp ?>"><?php echo $nrseqcomp ?></a>
            <?php }else{ ?>
            &nbsp;
            <?php }?>
            </td>
            <td width="70" align="center"<?php if($tiplcto == "D") echo " style=\"color:#FF0000\""; ?>><strong>R$ <?php echo number_format($vlrlcto,2,",",".") ?></strong></td>
            <td width="30" align="center"<?php if($tiplcto == "D") echo " style=\"color:#FF0000\""; ?>><?php echo $tiplcto; ?></td>
        </tr>
    </table>
<?php }?>
	<table width="615" class="textosver" bgcolor="#CACCE8" align="center">
    	<tr>
        	<td width="150">&nbsp;</td>
            <td align="right"><strong>Saldo Final:</strong></td>
            <td width="100" align="center">&nbsp;</td>
            <td width="70" align="center"><strong>R$ <?php echo number_format($valorfim,2,",",".") ?></strong></td>
            <td width="30" align="center">&nbsp;</td>
        </tr>
    </table>
<?php }?>
</body>
</html>

