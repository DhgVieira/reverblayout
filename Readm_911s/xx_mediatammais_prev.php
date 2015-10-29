<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 14px;
    }
</style>
</head>
<body>
<?php
include 'lib.php';
include 'auth.php';

$tam = request("tam");

$tot = 0;
$str = "SELECT NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, SUM(NR_QTDE_CESO) as total, DS_EXT_PRRC from compras, cestas, produtos where 
        NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
        NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
        NR_SEQ_CADASTRO_COSO not in (8074, 6605, 22364) and 
        ST_COMPRA_COSO <> 'C' AND
        NR_SEQ_TIPO_PRRC = 6 AND NR_SEQ_PRODUTO_PRRC not in (1998,2184,4544,2182,510,1759,4580,706,1773,2197)
        AND NR_SEQ_LOJAS_PRRC = 1 AND DT_COMPRA_COSO > '2011-08-01 00:00:00'
        GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc LIMIT 50";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    $totger = 0;
    while($row = mysql_fetch_row($st)) {
		$nrprod = $row[0];
        $dsprod = $row[1];
        $extens = $row[3];
        
        $str3 = "select month(DT_COMPRA_COSO), year(DT_COMPRA_COSO) from compras, cestas where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = $nrprod
        and ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) AND DT_COMPRA_COSO > '2011-08-01 00:00:00'
        GROUP BY month(DT_COMPRA_COSO), year(DT_COMPRA_COSO)";
        $st3 = mysql_query($str3);    
        $meses  = mysql_num_rows($st3);
        
        if ($meses <= 0) $meses = 1;
	    $str2 = "SELECT DS_TAMANHO_TARC, sum(NR_QTDE_CESO) 
                from compras, cestas, tamanhos where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC
                and ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
                and NR_SEQ_PRODUTO_CESO = $nrprod and LENGTH(DS_TAMANHO_TARC) > 6 AND DT_COMPRA_COSO > '2011-08-01 00:00:00'
                GROUP BY  NR_SEQ_TAMANHO_CESO
                order by NR_SEQ_TAMANHO_CESO
                ";
        $st2 = mysql_query($str2);
        if (mysql_num_rows($st2) > 0) {
            echo "<div style=\"float: left; margin: 0 10px 10px 0; min-height: 300px;\"><table><tr><td colspan=3 bgcolor=#e4e4e4>$dsprod</td></tr>";
            ?>
            <tr bgcolor="silver">
                <td align="left" rowspan="11"><img src="../arquivos/uploads/produtos/<?php echo $nrprod; ?>.<?php echo $extens; ?>" height="145"/><br /><?php echo $nrprod; ?></td>
                <td align="center"><strong>TAMANHO</strong></td>
                <td align="center"><strong>PREVIS&Atilde;O</strong></td>
            </tr>
            <?php
            $qtdetot = 0;
            $totvend = 0;
            
            while($row2 = mysql_fetch_row($st2)) {
                $dstam = $row2[0];
                $qtde = $row2[1];
                $qtdetot = ceil(($qtde/$meses))*2+(($qtde/$meses)*25/100);
                $totvend += ceil($qtdetot);
            ?>
            <tr>
                <td align="center"><?php echo $dstam; ?></td>
                <td align="center"><?php echo ceil($qtdetot); ?></td>
            </tr>
            <?php
            }
            $totger += $totvend;
            ?>
            <tr bgcolor="silver">
                <td align="left">&nbsp;</td>
                <td align="center" colspan="2"><strong><?php echo $totvend; ?></strong></td>
            </tr>
            <tr bgcolor="white">
                <td align="left">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
            </tr>
            </table></div>
            <?php
        }        
    }
}

?>
<div style="clear: both; width: 100%;"><p>TOTAL GERAL: <?php echo $totger;?></p></div>
</body>
</html>
<?php mysql_close($con); ?>