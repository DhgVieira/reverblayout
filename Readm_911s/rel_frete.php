<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$dataini = request ("dataini");
	$datafinal = request ("datafinal");
	/*list($data, $hora) = explode(" ",$dataini);
	list($dia, $mes, $ano) = explode("/",$data);
	$dataini = '1/'.$mes.'/'.$ano.' 00:00:00';
	$datafim = '31/'.$mes.'/'.$ano.' 23:59:59';*/
	$corpo = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatório</title>
<style>
	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:24px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:16px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
<script language="javascript">
	function valida(){ 

				
		if(document.formrel.email.value=="" || document.formrel.email.value.indexOf('@')==-1 || document.formrel.email.value.indexOf('.')==-1 ) 
		{ 
		alert( "Preencha o campo E-MAIL corretamente!" ); 
		document.formrel.email.focus(); 
		return false; 
		}
		
		document.formrel.submit();
		}
		
</script>
<script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
</head>
<body>

<form method="post" action="relatorios_funcoes.php" target="_blank" name="formrel"> 
<input type="hidden" name="aba" value="<?php echo $aba;?>"  />
<input type="hidden" name="assunto" value="Relatorio de Frete Cruzados" />
<table width="820">
	<tr>
    	<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
	    <td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td>
    </tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Cruzamento de frete</strong><br /><font size="-1"><?php echo $dataini.' - '.$datafinal;?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12" >
	<tr>
        <td align="left" width="100"><strong>Data</strong></td>
        <td align="left" width="100"><strong>Compra</strong></td>
        <td align="left" width="15"><strong>ST</strong></td>
        <td align="left" width="100"><strong>Frete</strong></td>
        <td align="left" width="100"><strong>Correio</strong></td>
        <td align="left" width="100"><strong>Diferen&ccedil;a</strong></td>
       
    </tr>
   	<tr><td colspan="6" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
    <?php $corpo .= "<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8 />
<title>ReverbCity - Relatório</title>
<style>
	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:24px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:16px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
</head>
<body><table width=820>
	<tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Relatório de Cruzamento de frete</strong><br /><font size=-1>".$mes.'/'.$ano."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
    <tr><td colspan=5 height=1></td></tr>
</table>
<table width=820 class=font12>
	<tr>
        <td align=left width=100><strong>Data</strong></td>
        <td align=left width=100><strong>Compra</strong></td>
        <td align=left width=15><strong>ST</strong></td>
        <td align=left width=100><strong>Frete</strong></td>
        <td align=left width=100><strong>Correio</strong></td>
        <td align=left width=100><strong>Diferen&ccedil;a</strong></td>
       
    </tr>
   	<tr><td colspan=6 height=2></td></tr>";?>
    
    
    <?php

	$sql = "SELECT DT_COMPRA_COSO, NR_SEQ_COMPRA_COSO, VL_FRETE_COSO, VL_FRETECUSTO_COSO, ST_COMPRA_COSO
			from compras where NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and
			(DT_COMPRA_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafinal','%d/%m/%Y %H:%i:%s'))
			and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' order by DT_COMPRA_COSO";

	$st = mysql_query($sql);
	$tt_fret = 0;
	$tt_corr = 0;
	$tt_corr2 = 0;
    
    $tt_fretegratis = 0;
    $tt_fretegratisqt = 0;
	$x=0;
	if (mysql_num_rows($st) > 0) {
		while($row = mysql_fetch_row($st)) {
			$dt_compra		= $row[0];
			$ds_compra		= $row[1];
			$vl_fret		= $row[2];
			$vl_corr		= $row[3];
            $st_compra		= $row[4];
            
			$vl_corr2		= $vl_fret - $vl_corr;
			
			$tt_fret += $vl_fret;
			$tt_corr += $vl_corr;
			$tt_corr2 += $vl_corr2;
            
            if ($vl_fret == 0 && $vl_corr > 0) {
                $tt_fretegratisqt++;
                $tt_fretegratis += $vl_corr;
            }
			?>
			<tr>
				<td align="left"><?php echo date('d/m/Y',strtotime($dt_compra)); ?></td>
				<td align="left"><a href="compras_ver.php?idc=<?php echo $ds_compra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $ds_compra ?>" class="thickbox"><?php echo $ds_compra; ?></a></td>
                <td align="center"><?php echo $st_compra; ?></td>
                <td align="left">R$ <?php echo number_format($vl_fret,2,",","."); ?></td>
                <td align="left"<?php if ($vl_corr == 0 && $vl_fret > 0) echo ' style="color: blue;font-weight: bold;"';?>>R$ <?php echo number_format($vl_corr,2,",","."); ?></td>
                <td align="left"<?php if ($vl_corr2 < 0) echo ' style="color: red;"';?>>R$ <?php echo number_format($vl_corr2,2,",","."); ?></td>
			</tr>
            <?php
			if ($x == 0) {
							 	$bg = "#CCCCCC";
								$x = 1;
							 }else{
							 	$bg = "#FFFFFF";
								$x = 0;
							 }
			$corpo .= "<tr  bgcolor=".$bg.">
				<td align=left>".date('d/m/Y',strtotime($dt_compra))."</td>
				<td align=left>".$ds_compra."</td>
                <td align=center>".$st_compra."</td>
                <td align=left>".number_format($vl_fret,2,",",".")."</td>
                <td align=left>".number_format($vl_corr,2,",",".")."</td>
                <td align=left>".number_format($vl_corr2,2,",",".")."</td>
			</tr>";?>
			<?
            }
	
		?>
        	<tr><td colspan="6" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="left"><strong>Total </strong></td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
				<td align="left"><strong>R$ <?php echo number_format($tt_fret,2,",","."); ?></strong></td>
                <td align="left"><strong>R$ <?php echo number_format($tt_corr,2,",","."); ?></strong></td>
                <td align="left"><strong>R$ <?php echo number_format($tt_corr2,2,",","."); ?></strong></td>
			</tr>
             <?php $corpo .= "<tr><td colspan=6 height=2></td></tr>
       		<tr>
				<td align=left><strong>Total </strong></td>
                <td align=left></td>
                <td align=left></td>
				<td align=left><strong>R$ ".number_format($tt_fret,2,",",".")."</strong></td>
                <td align=left><strong>R$ ".number_format($tt_corr,2,",",".")."</strong></td>
                <td align=left><strong>R$ ".number_format($tt_corr2,2,",",".")."</strong></td>
			</tr>
            <tr><td colspan=6>Total de compras com frete grátis: <strong>$tt_fretegratisqt</strong></td></tr>
            ";?>
        <?php
	}

?>
    <tr><td colspan="6" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
    <tr><td colspan="6" height="2">Total de compras com frete grátis: <strong><?php echo $tt_fretegratisqt; ?></strong> - Valor gasto: R$ <?php echo number_format($tt_fretegratis,2,",","."); ?></td></tr>
</table>
 <?php $corpo .= " <tr><td colspan=6 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
