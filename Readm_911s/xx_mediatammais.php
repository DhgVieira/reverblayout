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
$str = "SELECT NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, SUM(NR_QTDE_CESO) as total from compras, cestas, produtos where 
        NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
        NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
        NR_SEQ_CADASTRO_COSO not in (8074, 6605, 22364) and 
        ST_COMPRA_COSO <> 'C' AND
        NR_SEQ_TIPO_PRRC = 6 AND
        NR_SEQ_LOJAS_PRRC = 1
        GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc LIMIT 40";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
		$nrprod = $row[0];
        $dsprod = $row[1];
        
        $str3 = "select month(DT_COMPRA_COSO), year(DT_COMPRA_COSO) from compras, cestas where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = $nrprod
        and ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
        GROUP BY month(DT_COMPRA_COSO), year(DT_COMPRA_COSO)";
        $st3 = mysql_query($str3);    
        $meses  = mysql_num_rows($st3);
        
        if ($meses <= 0) $meses = 1;
	    $str2 = "SELECT DS_TAMANHO_TARC, sum(NR_QTDE_CESO) 
                from compras, cestas, tamanhos where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC
                and ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
                and NR_SEQ_PRODUTO_CESO = $nrprod and LENGTH(DS_TAMANHO_TARC) > 6
                GROUP BY  NR_SEQ_TAMANHO_CESO
                order by NR_SEQ_TAMANHO_CESO
                ";
        $st2 = mysql_query($str2);
        if (mysql_num_rows($st2) > 0) {
            echo "<div style=\"float: left; margin: 0 10px 10px 0; min-height: 300px;\"><table><tr><td colspan=3 bgcolor=#e4e4e4>$dsprod</td></tr>";
            ?>
            <tr bgcolor="silver">
                <td align="left">&nbsp;</td>
                <td align="center"><strong>TAMANHO</strong></td>
                <td align="center"><strong>MEDIA MES</strong></td>
            </tr>
            <?php
            $qtdetot = 0;
            $totvend = 0;
            while($row2 = mysql_fetch_row($st2)) {
                $dstam = $row2[0];
                $qtde = $row2[1];
                $qtdetot += $qtde/$meses;
                $totvend += $qtde;
            ?>
            <tr>
                <td align="center"><?php echo $qtde; ?></td>
                <td align="center"><?php echo $dstam; ?></td>
                <td align="center"><?php echo ceil($qtde/$meses); ?></td>
            </tr>
            <?php
            }
            ?>
            <tr bgcolor="silver">
                <td align="left"><?php echo $totvend; ?></td>
                <td align="right" colspan="2"><strong><?php echo round($qtdetot); ?>/mes em <?php echo $meses; ?> meses</strong></td>
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

</body>
</html>
<?php mysql_close($con); ?>